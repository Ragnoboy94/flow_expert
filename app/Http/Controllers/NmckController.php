<?php

namespace App\Http\Controllers;

use App\Models\MonthlyData;
use App\Models\PeriodicData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NmckController extends Controller
{
    public function storeData(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'monthlyData' => 'required|array',
            'monthlyData.*.month_id' => 'required|integer|min:1|max:12',
            'monthlyData.*.price' => 'required|numeric',
            'monthlyData.*.quantity' => 'required|integer',
            'periodicData' => 'required|array',
            'periodicData.*.period_id' => 'required|integer|min:1|max:4',
            'periodicData.*.quantity' => 'required|integer',
        ]);

        foreach ($data['monthlyData'] as $monthly) {
            MonthlyData::updateOrCreate(
                ['user_id' => $user->id, 'month_id' => $monthly['month_id']],
                ['price' => $monthly['price'], 'quantity' => $monthly['quantity']]
            );
        }

        foreach ($data['periodicData'] as $periodic) {
            PeriodicData::updateOrCreate(
                ['user_id' => $user->id, 'period_id' => $periodic['period_id']],
                ['quantity' => $periodic['quantity']]
            );
        }

        return response()->json(['message' => 'Data saved successfully!']);
    }

    public function getData()
    {
        $user = Auth::user();
        $monthlyData = MonthlyData::where('user_id', $user->id)->get();
        $periodicData = PeriodicData::where('user_id', $user->id)->get();

        return response()->json([
            'monthlyData' => $monthlyData,
            'periodicData' => $periodicData
        ]);
    }
}
