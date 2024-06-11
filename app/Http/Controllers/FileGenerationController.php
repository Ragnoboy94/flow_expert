<?php

namespace App\Http\Controllers;

use App\Exports\ExcelRowExport;
use App\Models\DemandFile;
use App\Models\DrugCategory;
use App\Models\ExcelRow;
use App\Models\GeneratedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class FileGenerationController extends Controller
{
    public function download(Request $request, $fileId, $categoryId)
    {
        DemandFile::findOrFail($fileId);

        if ($categoryId === 'no-category') {
            $categoryId = null;
            $categoryName = 'Без категории';
        } else {
            DrugCategory::findOrFail($categoryId);
            $category = DrugCategory::findOrFail($categoryId);
            $categoryName = $category->name;
        }

        $generatedFile = GeneratedFile::where('demand_file_id', $fileId)
            ->where('category_id', $categoryId)
            ->first();

        $latestUpdate = ExcelRow::where('demand_file_id', $fileId)
            ->where('drug_category_id', $categoryId)
            ->max('updated_at');


        $needsNewFile = !$generatedFile || $latestUpdate > $generatedFile->updated_at;

        if ($needsNewFile) {
            $filename = 'generated_files/' . $fileId . '_' . $categoryId . '_' . now()->timestamp . '.xlsx';
            Excel::store(new ExcelRowExport($fileId, $categoryId, $categoryName), $filename, 'public');

            if ($generatedFile) {
                $generatedFile->update(['filename' => $filename]);
            } else {
                GeneratedFile::create([
                    'demand_file_id' => $fileId,
                    'category_id' => $categoryId,
                    'filename' => $filename,
                ]);
            }
        } else {
            $filename = $generatedFile->filename;
        }

        return response()->json(['fileUrl' => $filename]);
    }
}
