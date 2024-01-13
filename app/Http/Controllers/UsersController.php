<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersController extends Controller
{

    public function create(Request $request)
    {
        $this->validate($request,[
            "name"=>"required|max:255",
            "email"=>"required|unique:users|email",
            "password"=>"required|min:6"
        ]);

        $user = User::create($request->only(['name', 'email', 'password']));
        $token = JWTAuth::fromUser($user);

        return response()->json([
            "message"=>"Registrado con exito.",
            "user"=>$user,
            "token"=>$token
        ],201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciales no válidas'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }

}
