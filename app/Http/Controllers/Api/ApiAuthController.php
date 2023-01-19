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
        
        // check if user exist
        $user = User::where('email',$request->email)->first();

        //check if password correct dan user ada
        if (!$user|| Hash::check($request->password,$user->password)) {
            return response()->json([
                'message' => 'Bad credentials'
            ],401);
        }

        //generate token
        // bebas bisa nama token, soko atau dll
        // return $user->createToken('token')->plainTextToken;
        $token = $user->createToken('token')->plainTextToken;

        // yg di kembalikan array bukan model seperti quote resorce
        return new LoginResource([
            // 'message' => 'success',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function register(Request $request){

    }

    public function logout(Request $request){

    }
}
