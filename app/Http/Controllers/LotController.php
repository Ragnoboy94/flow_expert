<?php

namespace App\Http\Controllers;

use App\Models\DemandFile;
use Illuminate\Http\Request;

class LotController extends Controller
{
    public function splitLots(Request $request)
    {
        $fileId = $request->input('fileId');
        $selectedLaw = $request->input('selectedLaw');

        $demandFile = DemandFile::find($fileId);

        if ($demandFile) {
            $demandFile->update([
                'status_id' => 5,
            ]);

            return response()->json(['message' => 'Файл успешно разбит на лоты', 'fileId' => $fileId, 'selectedLaw' => $selectedLaw]);
        }

        return response()->json(['message' => 'Файл не найден'], 404);
    }
}
