<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function getCustomer()
    {
        $user = Auth::user();
        $customer = $user->customer;
        if ($customer) {
            return response()->json($customer);
        } else {
            return response()->json([
                'name' => $user->name,
                'inn' => $user->inn,
                'kpp' => $user->kpp
            ]);
        }
    }

    public function updateCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'inn' => 'required|string|max:15',
            'kpp' => 'required|string|max:15',
        ]);

        $user = Auth::user();
        $customer = $user->customer;

        if ($customer) {
            $customer->update($request->all());
        } else {
            $customer = new Customer($request->all());
            $customer->user_id = $user->id;
            $customer->save();
        }

        return response()->json($customer);
    }

    public function updateAdditionalData(Request $request)
    {
        $request['region_id'] = $request['region']['id'];
        $request->validate([
            'order567' => 'boolean',
            'order450n' => 'boolean',
            'fz44' => 'boolean',
            'fz223' => 'boolean',
            'eaec' => 'boolean',
            'completed' => 'boolean',
            'inProgress' => 'boolean',
            'terminated' => 'boolean',
            'cancelled' => 'boolean',
            'endDate' => 'date',
            'endDate2' => 'date',
            'signDate' => 'date|nullable',
            'signDate2' => 'date|nullable',
            'region' => 'string|max:255',
            'noPenalties1' => 'boolean',
            'noPenalties2' => 'boolean',
            'excludedContracts' => 'string|max:255',
            'noIndexation' => 'boolean',
            'variationLimit' => 'numeric',
            'decimalPlaces' => 'integer|min:0|max:15'
        ]);

        $user = Auth::user();
        $customer = $user->customer;

        if ($customer) {
            $customer->update($request->all());
        } else {
            $customer = new Customer($request->all());
            $customer->user_id = $user->id;
            $customer->save();
        }

        return response()->json($customer);
    }

    public function getRegion()
    {
        $regions = Region::all();
        return response()->json($regions);
    }
}
