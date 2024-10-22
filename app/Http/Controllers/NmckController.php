<?php

namespace App\Http\Controllers;

use App\Exports\NmckExport;
use App\Jobs\NmckExportJob;
use App\Models\MonthlyData;
use App\Models\NmckFile;
use App\Models\PeriodicData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class NmckController extends Controller
{
    public function storeData(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'requestData.fileId' => 'required|integer|exists:demand_files,id',
            'requestData.offerIds' => 'required|array',
            'requestData.offerIds.*' => 'integer|exists:offers,id',
            'requestData.openSource' => 'required|boolean',
        ]);

        $filename = 'nmck_' . now()->timestamp . '.xlsx';
        $filePath = 'nmck_files/' . $filename;

        $nmckFile = NmckFile::create([
            'user_id' => $user->id,
            'filename' => $filePath,
        ]);
        if ($data['requestData']['openSource']) {
            NmckExportJob::dispatch($data['requestData']['fileId'], $data['requestData']['offerIds'], $data['requestData']['openSource'], $filePath, $nmckFile);
        } else {
            Excel::store(new NmckExport($data['requestData']['fileId'], $data['requestData']['offerIds'], $data['requestData']['openSource']), $filePath, 'public');
            $nmckFile->update(['status_id' => 3]);
        }

        return response()->json(['message' => 'Data saved successfully!', 'fileUrl' => asset($filePath)]);
    }

    public function getData(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'excel_row_id' => 'required|integer|exists:excel_rows,id'
        ]);
        $excelRowId = $request->input('excel_row_id');

        $monthlyData = MonthlyData::where('excel_row_id', $excelRowId)
            ->where(function ($query) use ($user) {
                if ($user->position_id === 1) {
                    $query->whereHas('user', function ($query) use ($user) {
                        $query->where('organization_id', $user->organization_id);
                    });
                } else {
                    $query->where('user_id', $user->id);
                }
            })->get();

        $periodicData = PeriodicData::where('excel_row_id', $excelRowId)
            ->where(function ($query) use ($user) {
                if ($user->position_id === 1) {
                    $query->whereHas('user', function ($query) use ($user) {
                        $query->where('organization_id', $user->organization_id);
                    });
                } else {
                    $query->where('user_id', $user->id);
                }
            })->get();

        return response()->json([
            'monthlyData' => $monthlyData,
            'periodicData' => $periodicData
        ]);
    }

    public function saveMonthlyAndPeriodicData(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'monthlyData' => 'required|array',
            'monthlyData.*.month_id' => 'required|integer|min:1|max:12',
            'monthlyData.*.price' => 'required|numeric',
            'monthlyData.*.quantity' => 'required|integer',
            'monthlyData.*.excel_row_id' => 'required|integer|exists:excel_rows,id',
            'periodicData' => 'required|array',
            'periodicData.*.period_id' => 'required|integer|min:1|max:4',
            'periodicData.*.quantity' => 'required|integer',
            'periodicData.*.excel_row_id' => 'required|integer|exists:excel_rows,id',
        ]);

        foreach ($data['monthlyData'] as $monthly) {
            MonthlyData::updateOrCreate(
                ['user_id' => $user->id, 'month_id' => $monthly['month_id'], 'excel_row_id' => $monthly['excel_row_id']],
                ['price' => $monthly['price'], 'quantity' => $monthly['quantity']]
            );
        }

        foreach ($data['periodicData'] as $periodic) {
            PeriodicData::updateOrCreate(
                ['user_id' => $user->id, 'period_id' => $periodic['period_id'], 'excel_row_id' => $periodic['excel_row_id']],
                ['quantity' => $periodic['quantity']]
            );
        }

        return response()->json(['message' => 'Monthly and periodic data saved successfully!']);
    }

    public function getNmckFiles()
    {
        $user = Auth::user();
        $files = NmckFile::where('user_id', $user->id)->where('status_id', 3)->get();

        return response()->json($files);
    }
}
