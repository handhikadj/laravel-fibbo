<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login()
    {
        request()->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', request()->email)->first();

        if (!$user || !Hash::check(request()->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        return response()->json([
            'access_token' => $user->createToken(request()->email)->plainTextToken
        ], 200);
    }
}
