<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class PasswordController extends Controller
{
    public function forgot(Request $request)
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
        $user->password = Hash::make($password);
        $user->save();

        return response()->json(['message' => 'Код для смены пароля отправлен', 'password' => $password]);
    }

    public function change(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Неверный старый пароль'], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Пароль успешно изменен']);
    }
}
