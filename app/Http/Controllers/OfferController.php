<?php

namespace App\Http\Controllers;

use App\Exports\MedicinesRowsExport;
use App\Jobs\ConvertPdfToExcel;
use App\Models\MedicineRows;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class OfferController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $offersQuery = Offer::query();

        if ($user->position_id == 1) {
            $offersQuery->whereHas('user', function ($query) use ($user) {
                $query->where('organization_id', $user->organization_id);
            });
        } else {
            $offersQuery->where('user_id', $user->id);
        }

        $offers = $offersQuery->get();

        $response = [];
        foreach ($offers as $offer) {
            if ($offer->file_status_id == 3 && !empty($offer->excel_file_path)) {
                $medicineRows = MedicineRows::where('offer_id', $offer->id)->get();
                if ($offer->updated_at > $offer->exel_exported_at || is_null($offer->exel_exported_at)) {
                    $filePath = 'offers_export/' . $offer->excel_file_path;
                    Excel::store(new MedicinesRowsExport($offer), $filePath, 'public', \Maatwebsite\Excel\Excel::XLSX);
                    $offer->update(['exel_exported_at' => now()]);
                }
                $response[] = [
                    'offer' => $offer,
                    'medicine_rows' => $medicineRows
                ];
            } else {
                $response[] = [
                    'offer' => $offer
                ];
            }
        }

        return response()->json($response);
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

            ConvertPdfToExcel::dispatch($offer);

            return response()->json(['message' => 'Offer created successfully', 'offer' => $offer], 201);
        }

        return response()->json(['message' => 'File not uploaded'], 400);
    }
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $row = MedicineRows::findOrFail($id);

        if ($user->position_id == 1 && $row->offer && $row->offer->user->organization_id != $user->organization_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($row->offer && $row->offer->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $row->update($request->all());

        if ($row->offer) {
            $row->offer->touch();
        }

        return response()->json($row);
    }

}
