<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessExcelFile;
use App\Models\DemandFile;
use App\Models\DrugCategory;
use App\Models\ExcelRow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LotController extends Controller
{
    public function splitLots(Request $request)
    {
        $fileId = $request->input('fileId');
        $selectedLaw = $request->input('selectedLaw');

        $user = Auth::user();

        if ($user->position_id === 1) {
            $file = DemandFile::where('id', $fileId)
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('organization_id', $user->organization_id);
                })
                ->firstOrFail();
        } else {
            $file = DemandFile::where('id', $fileId)
                ->where('user_id', $user->id)
                ->firstOrFail();
        }

        $file->update(['status_id' => 5, 'law' => $selectedLaw]);

        ProcessExcelFile::dispatch($file);

        return response()->json(['message' => 'Файл успешно разбит на лоты', 'fileId' => $fileId, 'selectedLaw' => $selectedLaw]);
    }
    public function getExcelRows($fileId)
    {
        $user = Auth::user();

        if ($user->position_id === 1) {
            $file = DemandFile::where('id', $fileId)
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('organization_id', $user->organization_id);
                })
                ->firstOrFail();
        } else {
            $file = DemandFile::where('id', $fileId)
                ->where('user_id', $user->id)
                ->firstOrFail();
        }

        $rows = ExcelRow::where('demand_file_id', $file->id)->with('drugCategory')->get();

        return response()->json($rows);
    }
    public function updateExcelRows(Request $request, $fileId)
    {
        $user = Auth::user();

        if ($user->position_id === 1) {
            $file = DemandFile::where('id', $fileId)
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('organization_id', $user->organization_id);
                })
                ->firstOrFail();
        } else {
            $file = DemandFile::where('id', $fileId)
                ->where('user_id', $user->id)
                ->firstOrFail();
        }

        $rows = $request->all();
        foreach ($rows as $row) {
            ExcelRow::where('id', $row['id'])
                ->where('demand_file_id', $file->id)
                ->update($row);
        }

        return response()->json(['message' => 'Строки успешно обновлены']);
    }

    public function categoryList()
    {
        $categories = DrugCategory::all();
        return response()->json($categories);
    }
}
