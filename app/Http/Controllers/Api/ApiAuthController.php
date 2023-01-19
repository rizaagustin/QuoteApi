<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{

    public function login(LoginRequest $request){        
        // validate dengan Auth:attemp bawan laravel
        $credentials = $request->only('email','password');
        if (Auth::attempt($credentials)) {
            // jika berhasil berikan token
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('token')->plainTextToken;
            return new LoginResource([
                'user' => $user,
                'token' => $token
            ]);
        }else{
            // jika gagal response error    
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }
    }

    public function register(Request $request){

    }

    public function logout(Request $request){

    }
}
