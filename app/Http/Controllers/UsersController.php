<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersController extends Controller
{

    public function create(Request $request)
    {
        $this->validate($request,[
            'name'=>"required|max:255",
            "email"=>"required|unique:users|email",
            "password"=>"requred|min:6"
        ]);

        $user = User::create($request->only(['name', 'email', 'password']));
        $token = JWTAuth::fromUser($user);

        return response()->json([
            "message"=>"Registrado con exito.",
            "user"=>$user,
            "token"=>$token
        ],201);
    }

}
