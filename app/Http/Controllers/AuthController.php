<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Middleware\JWT;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['signup', 'login']]);
    }

    public function signup(RegisterRequest $request)
    {
        $user = User::create($request->all());
        $token = auth()->login($user);
        return $this->respondWithToken($token);
    }

    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user(), Response::HTTP_OK);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'successsfully logged out'], Response::HTTP_OK);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function payload()
    {
        return auth()->payload();
        // then you can access the claims directly e.g.
        // $payload->get('sub'); // = 123
        // $payload['jti']; // = 'asfe4fq434asdf'
        // $payload('exp') // = 123456
        // $payload->toArray(); // = ['sub' => 123, 'exp' => 123456, 'jti' => 'asfe4fq434asdf'] etc
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()->name,
        ], Response::HTTP_OK);
    }
}
