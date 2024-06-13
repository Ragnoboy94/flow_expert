<?php

namespace App\Http\Controllers;

use App\Exports\NmckExport;
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
            'monthlyData' => 'required|array',
            'monthlyData.*.month_id' => 'required|integer|min:1|max:12',
            'monthlyData.*.price' => 'required|numeric',
            'monthlyData.*.quantity' => 'required|integer',
            'periodicData' => 'required|array',
            'periodicData.*.period_id' => 'required|integer|min:1|max:4',
            'periodicData.*.quantity' => 'required|integer',
        ]);

        foreach ($data['monthlyData'] as $monthly) {
            MonthlyData::updateOrCreate(
                ['user_id' => $user->id, 'month_id' => $monthly['month_id']],
                ['price' => $monthly['price'], 'quantity' => $monthly['quantity']]
            );
        }

        foreach ($data['periodicData'] as $periodic) {
            PeriodicData::updateOrCreate(
                ['user_id' => $user->id, 'period_id' => $periodic['period_id']],
                ['quantity' => $periodic['quantity']]
            );
        }

        $filename = 'nmck_' . now()->timestamp . '.xlsx';

        $filePath = 'nmck_files/' . $filename;
        Excel::store(new NmckExport($data['requestData']['fileId'], $data['requestData']['offerIds'], $data['monthlyData'], $data['periodicData'], $data['requestData']['openSource']), $filePath, 'public');

        // Сохранение информации о файле
        NmckFile::create([
            'user_id' => $user->id,
            'filename' => $filePath,
        ]);

        return response()->json(['message' => 'Data saved successfully!']);
    }

    public function getData()
    {
        $user = Auth::user();
        $monthlyData = MonthlyData::where('user_id', $user->id)->get();
        $periodicData = PeriodicData::where('user_id', $user->id)->get();

        return response()->json([
            'monthlyData' => $monthlyData,
            'periodicData' => $periodicData
        ]);
    }
}
