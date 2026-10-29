<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('/refresh-token', [AuthController::class, 'refresh_token']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('mahasiswa', MahasiswaController::class, [
        'except' => ['create', 'edit']
    ]);

    Route::apiResource('dosen', DosenController::class, [
        'except' => ['create', 'edit']
    ]);

     // Mengambil profil pengguna yang sedang login
    Route::get('/user', function () {
        return response()->json(auth('api')->user());
     });
});