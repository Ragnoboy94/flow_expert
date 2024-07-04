<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailConfirmed;
use App\Mail\VerifyEmail;
use App\Models\Organization;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'phone' => 'required|int|min:11|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'category_id' => 'required|exists:categories,id',
            'organization_id' => 'required|exists:organizations,id',
            'position_id' => 'required|exists:positions,id'

        ]);
        $existingUser = User::where('organization_id', $validated['organization_id'])
            ->where('position_id', $validated['position_id'])
            ->first();

        if ($existingUser) {
            return response()->json([
                'success' => false,
                'message' => 'Эта должность уже занята в выбранной организации.'
            ], 422);
        }

        $user = User::create([
            'name' => $validated['fullName'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'category_id' => $validated['category_id'],
            'organization_id' => $validated['organization_id'],
            'position_id' => $validated['position_id'],
            'verification_token' => Str::uuid()->toString()
        ]);

        $position = Position::find($validated['position_id']);
        $organization = Organization::find($validated['organization_id']);
        $positionName = $position ? $position->name : '';
        $organizationName = $organization ? $organization->name : '';

        $verificationUrl = config('app.url') . '/?access_token=' . $user->verification_token;

        Mail::to($organization->email)->send(new VerifyEmail($user, $verificationUrl, $positionName, $organizationName));

        return response()->json(['success' => true, 'user' => $user, 'message' => 'Registration successful'], 201);
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'token' => 'required|uuid',
        ]);

        $user = User::where('verification_token', $request->token)->firstOrFail();

        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();

        Mail::to($user->email)->send(new EmailConfirmed($user));

        return response()->json(['message' => 'Email успешно подтвержден.']);
    }
}
