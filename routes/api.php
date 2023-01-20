<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\UploadFileController;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/hello', function () {    
    $data = ['message' => 'hello World'];
    return response()->json($data,200);
});

Route::middleware('auth:sanctum')->get('/user', function(Request $request){
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/quote',QuoteController::class);
    Route::post('/logout', [ApiAuthController::class, 'logout']);
});

// bisa di akses di public
Route::post('/register', [ApiAuthController::class,'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/file-upload', [UploadFileController::class, 'uploadFile']);



