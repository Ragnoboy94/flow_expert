<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|min:11',
            'password' => 'required|min:8'
        ]);

        $request = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => config('auth.passport.client_id'),
            'client_secret' => config('auth.passport.client_secret'),
            'username' => $request->phone,
            'password' => $request->password,
        ]);

        return app()->handle($request);
    }

    /**
     * @throws ValidationException
     */
    public function verify(Request $request)
    {
        $request->validate([
            'fullName' => 'required',
            'phone' => 'required|min:11',
        ]);
        $user = User::where(function ($query) use ($request) {
            $query->where('name', $request->fullName)->orWhere('name', mb_strtolower($request->fullName));
        })->where('phone', $request->phone)->first();

        if ($user) {
            return response()->json(['message' => 'User verified', 'verified' => true]);
        } else {
            return response()->json(['message' => 'Пользователь не найден', 'verified' => false], 404);
        }
    }

    public function logout()
    {
        $accessToken = auth()->user()->token();

        DB::table('oauth_access_tokens')->where('id', $accessToken->id)->delete();
        DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->delete();

        return response()->json(['status' => 200]);
    }

}
