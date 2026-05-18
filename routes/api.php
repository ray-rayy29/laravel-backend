<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\KeteranganController;
use App\Http\Controllers\BukuTematikController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AtkController;
use App\Http\Controllers\BarangController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'user'])->middleware('auth:sanctum');

// Route Resource
Route::apiResource('data', DataController::class);
Route::apiResource('keterangan', KeteranganController::class);
Route::apiResource('buku-tematik', BukuTematikController::class);

Route::apiResource('atk', AtkController::class);
Route::apiResource('barang', BarangController::class);
