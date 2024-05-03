<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class PasswordController extends Controller
{
    public function change(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,phone',
            'fullName' => 'required',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if ($user->name !== $request->fullName) {
            return response()->json(['message' => 'Пользователь не найден'], 422);
        }

        $password = rand(10000000, 99999999);
        $user->password = $password;
        $user->save();

        return response()->json(['message' => 'Код для смены пароля отправлен', 'password' => $password]);
    }
}
