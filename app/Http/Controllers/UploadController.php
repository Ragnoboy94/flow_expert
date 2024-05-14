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
        $filesToCheck = DemandFile::where('user_id', Auth::id())
            ->where('status_id', 2)
            ->whereNotNull('file_work_id')
            ->get();

        foreach ($filesToCheck as $file) {
            CheckAndDownloadProcessedFile::dispatch($file);
        }

        if ($request->status_id) {
            $allFiles = DemandFile::where('user_id', Auth::id())
                ->where(function ($query) use ($request) {
                    $query->where('status_id', $request->status_id)
                        ->orWhere('status_id', 5);
                })
                ->get();
        } else {
            $allFiles = DemandFile::where('user_id', Auth::id())->get();
        }
        return response()->json($allFiles);
    }

}
