<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            "email" => $request->input("email"),
            "password" => $request->input("password"),
        ];

        if(Auth::attempt($credentials)){
            $token = auth()->user()->createToken("api-login");
            return Response::success(["token" => $token->plainTextToken]);
        }

        return Response::error("messages.common.login_error",401);
    }


    /**
     * @param Request $request
     * @return User
     */
    public function me(Request $request)
    {
        return new User($request->user());
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return Response::success("messages.common.logout");
    }
}
