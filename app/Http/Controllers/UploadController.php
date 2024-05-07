<?php

namespace App\Http\Controllers;

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
            /*
             * Очередь для отправки файла на обработку
             */
            //SendFileToGrantAPI::dispatch($destinationPath . '/' . $filename, $demandFile);
            return response()->json(['message' => 'File uploaded successfully', 'filename' => $filename], 200);
        }

        return response()->json(['message' => 'File not provided'], 400);
    }

    public function index(Request $request)
    {
        $files = DemandFile::with('status')->where('user_id', Auth::id())->get();
        return response()->json($files);
    }
}
