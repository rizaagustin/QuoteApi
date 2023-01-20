<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
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
            //token lama dihapus
            $request->user()->tokens()->delete();
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

    public function register(RegisterRequest $request){
        // save user to user table
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('token')->plainTextToken;

        //return token
        return new LoginResource([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function logout(Request $request){
        
        //hapus token by usernya
        // $request->user()->currentAccessToken()->delete();

        //hpaus semua token by user karena user tidak boleh punya 1 token
        $request->user()->tokens()->delete();

        //response no content
        return response()->noContent();
    }
}
