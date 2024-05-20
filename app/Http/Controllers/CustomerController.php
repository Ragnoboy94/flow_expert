<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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

        return response()->json(['message' => 'User not found'], 404);
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
}
