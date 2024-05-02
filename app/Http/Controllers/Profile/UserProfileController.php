<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return response()->json($user);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'inn' => 'nullable|numeric',
            'kpp' => 'nullable|numeric',
            'phone' => 'sometimes|string',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return response()->json(['message' => 'Профиль успешно обновлен', 'user' => $user]);
    }
}
