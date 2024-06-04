<?php

namespace App\Http\Controllers;

use App\Models\DemandFile;
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
}
