<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        return true;
    }

    public function verify(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|min:16', // Убедитесь, что формат номера соответствует вашим требованиям
        ]);

        $user = User::where('name', $request->name)
            ->where('phone', $request->phone)
            ->first();

        if ($user) {
            return response()->json(['message' => 'User verified', 'verified' => true]);
        } else {
            return response()->json(['message' => 'User not found', 'verified' => false], 404);
        }
    }

}
