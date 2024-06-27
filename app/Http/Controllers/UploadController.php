<?php

namespace App\Http\Controllers;

use App\Jobs\CheckAndDownloadProcessedFile;
use App\Jobs\SendFileToGrantAPI;
use App\Models\DemandFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');

        if ($file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $filename);

            $demandFile = DemandFile::create([
                'user_id' => Auth::id(),
                'filename' => $filename
            ]);
            SendFileToGrantAPI::dispatch($destinationPath . '/' . $filename, $demandFile);
            return response()->json(['message' => 'File uploaded successfully', 'filename' => $filename], 200);
        }

        return response()->json(['message' => 'File not provided'], 400);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $filesToCheckQuery = DemandFile::query();

        if ($user->position_id == 1) {
            $filesToCheckQuery->whereHas('user', function ($query) use ($user) {
                $query->where('organization_id', $user->organization_id);
            });
        } else {
            $filesToCheckQuery->where('user_id', $user->id);
        }

        $filesToCheck = $filesToCheckQuery
            ->where('status_id', 2)
            ->whereNotNull('file_work_id')
            ->get();

        foreach ($filesToCheck as $file) {
            CheckAndDownloadProcessedFile::dispatch($file);
        }

        $allFilesQuery = DemandFile::query();

        if ($user->position_id == 1) {
            $allFilesQuery->whereHas('user', function ($query) use ($user) {
                $query->where('organization_id', $user->organization_id);
            });
        } else {
            $allFilesQuery->where('user_id', $user->id);
        }

        if ($request->status_id) {
            $allFilesQuery->where(function ($query) use ($request) {
                $query->where('status_id', $request->status_id)
                    ->orWhere('status_id', 5);
            });
        }

        $allFiles = $allFilesQuery->get();
        return response()->json($allFiles);
    }

}
