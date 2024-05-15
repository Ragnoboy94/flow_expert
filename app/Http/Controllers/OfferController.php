<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'sender' => 'required|string',
            'date' => 'required|date',
            'positions' => 'required|integer',
            'file' => 'required|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('/offers');
            $file->move($destinationPath, $filename);

            $offer = new Offer();
            $offer->sender = $request->input('sender');
            $offer->date = $request->input('date');
            $offer->positions = $request->input('positions');
            $offer->file_path = $filename;
            $offer->save();

            return response()->json(['message' => 'Offer created successfully', 'offer' => $offer], 201);
        }

        return response()->json(['message' => 'File not uploaded'], 400);
    }
}
