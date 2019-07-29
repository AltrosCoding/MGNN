<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')
        ->except([
            'register', 
            'login', 
        ]);
    }

    public function register(Request $request)
    {
        $user = User::create([
            'user_name' => $request->user_name,
            'password' => $request->password,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => 'user',
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            $this->logout($request);
        }

        $credentials = $request->only(['user_name', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    protected function respondWithToken($token)
    {
      return response()->json([
        'accessToken' => $token,
        'tokenType' => 'bearer',
        'expiresOn' => $this->ttlDatetime(auth()->factory()->getTTL()),
      ]);
    }

    private function ttlDatetime($ttl) {
        $time = new \DateTime();

        $time->modify("+{$ttl} minutes");

        return $time->format('Y-m-d H:i');
    }
}
