<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->all();
        $user = User::where('login', $data['login'])->first();
        if (!Hash::check($data['password'], $user->password)){
            throw new \Exception('invalid password');
        }

        if ($user) {
            $token = Str::random(40);
            $expireDate = date('Y-m-d H:i:s', time() + 60*60*24);
            $user->remember_token = $token;
            $user->token_expires = $expireDate;
            $user->save();

            return response()->json(['user' => $user, 'remember_token' => $token]);
        }

        throw new \Exception('unauth');
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        $user = User::where('token', $token)->first();

        if ($user) {
            $token = Str::random(40);
            $expireDate = date('Y-m-d H:i:s', time() + 60*60*24);
            $user->remember_token = $token;
            $user->token_expires = $expireDate;
            $user->save();

            $response = ['message' => 'You have been successfully logged out!'];
            return response()->json($response);
        }

        throw new \Exception('unauth');
    }
}
