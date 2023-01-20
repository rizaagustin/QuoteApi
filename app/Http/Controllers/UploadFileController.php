<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadFileController extends Controller
{

    public function uploadFile(Request $request){
        
        $validated = $request->validate([
            'avatar' => 'required|mimes:jpeg,jpg,png',
        ]);

        $path = $request->file('avatar')->store('avatars');

        $data = [
            'message' => 'File Uploaded',
            'path' => $path
        ];

        return response()->json($data,200);
    }

}
