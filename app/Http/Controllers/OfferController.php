<?php

namespace App\Http\Controllers;

use App\Jobs\ConvertPdfToExcel;
use App\Jobs\ImportExcelData;
use App\Models\MedicineRows;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::where('user_id', Auth::id())->firstOrFail();

        if ($offers->file_status_id == 3 && !empty($offers->excel_file_path)) {
            $medicineRows = MedicineRows::where('offer_id', $offers->id)->get();

            return response()->json([
                'offer' => $offers,
                'medicine_rows' => $medicineRows
            ]);
        }
        return response()->json(['offer' => $offers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'sender' => 'required|string',
            'date' => 'required|date',
            'positions' => 'required|integer',
            'file' => 'required|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $offer = Offer::where('user_id', Auth::id())->get()->first();
            if ($offer) {
                if (Storage::disk('public')->exists('/offers/' . $offer->file_path)) {
                    Storage::disk('public')->delete('/offers/' . $offer->file_path);
                }
                if ($offer->excel_file_path && Storage::disk('public')->exists('/offers' . $offer->excel_file_path)) {
                    Storage::disk('public')->delete('/offers/' . $offer->excel_file_path);
                }
                $offer->delete();
            }
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('/offers');
            $file->move($destinationPath, $filename);

            $offer = new Offer();
            $offer->user_id = auth()->id();
            $offer->sender = $request->input('sender');
            $offer->date = $request->input('date');
            $offer->positions = $request->input('positions');
            $offer->file_path = $filename;
            $offer->file_status_id = 1;
            $offer->save();

            MedicineRows::where('user_id', Auth::id())->delete();

            //ConvertPdfToExcel::dispatch($offer);

            return response()->json(['message' => 'Offer created successfully', 'offer' => $offer], 201);
        }

        return response()->json(['message' => 'File not uploaded'], 400);
    }
    public function update(Request $request, $id)
    {
        $row = MedicineRows::findOrFail($id);
        $row->update($request->all());
        return response()->json($row);
    }

}
