<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessExcelFile;
use App\Models\DemandFile;
use App\Models\ExcelRow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LotController extends Controller
{
    public function splitLots(Request $request)
    {
        $fileId = $request->input('fileId');
        $selectedLaw = $request->input('selectedLaw');

        $file = DemandFile::where('id', $fileId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $file->update(['status_id' => 5, 'law' => $selectedLaw]);

        ProcessExcelFile::dispatch($file);

        return response()->json(['message' => 'Файл успешно разбит на лоты', 'fileId' => $fileId, 'selectedLaw' => $selectedLaw]);
    }
    public function getExcelRows($fileId)
    {
        $file = DemandFile::where('id', $fileId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $rows = ExcelRow::where('demand_file_id', $file->id)->get();

        return response()->json($rows);
    }
}
