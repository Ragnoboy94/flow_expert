<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');

        if ($file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            return response()->json(['message' => 'File uploaded successfully', 'filename' => $filename], 200);
        }

        return response()->json(['message' => 'File not provided'], 400);
    }
}
