<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\MahasiswaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/mahasiswa')->group(function () {
    Route::get('', [MahasiswaController::class, 'index']);
    Route::post('', [MahasiswaController::class, 'create']);
    Route::get('/{id}', [MahasiswaController::class, 'detail']);
    Route::put('/{id}', [MahasiswaController::class, 'update']);
    Route::delete('/{id}', [MahasiswaController::class, 'delete']);
});
