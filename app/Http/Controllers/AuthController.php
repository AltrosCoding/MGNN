<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'user_name' => $request->user_name,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'email' => $request->email,
            'role' => $request->role,
            'ad_sense_snippet' => $request->ad_sense_snippet,
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['user_name', 'password']);

        //dd($credentials);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
      return response()->json([
        'accessToken' => $token,
        'tokenType' => 'bearer',
        'expiresIn' => auth()->factory()->getTTL() * 60
      ]);
    }
}
