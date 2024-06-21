<?php

namespace App\Http\Controllers;

use App\Models\DemandFile;
use App\Models\MedicineRows;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeleteController extends Controller
{
    public function deleteDemand(int $fileId): void
    {
        $demandFile = DemandFile::where('user_id', Auth::id())->where('id', $fileId)->get()->first();
        if ($demandFile) {
            if (Storage::disk('public')->exists('/uploads/' . $demandFile->filename)) {
                Storage::disk('public')->delete('/uploads/' . $demandFile->filename);
            }
            if ($demandFile->new_filename && Storage::disk('public')->exists('/processed_files/' . $demandFile->new_filename)) {
                Storage::disk('public')->delete('/processed_files/' . $demandFile->new_filename);
            }
            $demandFile->delete();
        }
    }

    public function deleteOffer(int $fileId): void
    {
        $offer = Offer::where('user_id', Auth::id())->where('id', $fileId)->get()->first();
        if ($offer) {
            if (Storage::disk('public')->exists('/offers/' . $offer->file_path)) {
                Storage::disk('public')->delete('/offers/' . $offer->file_path);
            }
            if ($offer->excel_file_path && Storage::disk('public')->exists('/offers/' . $offer->excel_file_path)) {
                Storage::disk('public')->delete('/offers/' . $offer->excel_file_path);
            }
            MedicineRows::where('offer_id', $fileId)->delete();
            $offer->delete();
        }
    }
}
