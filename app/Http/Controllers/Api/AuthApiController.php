<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'errors' => $validator->errors()
            ], 400));
        }

        if (Auth::guard('penyewa')->attempt($request->only(['email', 'password']))) {

            $user = auth('penyewa')->user();
            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json(["token" => $token, "user" => $user], 200);
        }

        throw new HttpResponseException(response()->json([
            "error" => [
                "message" => "Email atau password Salah"
            ]
        ], 401));
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
