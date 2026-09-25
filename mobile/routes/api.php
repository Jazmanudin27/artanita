<?php

use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MapelController;
use App\Http\Controllers\Api\PresensiController;
use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\JadwalController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json([
        'status' => 'online',
        'message' => 'Artanita Presensi Guru API Service',
        'version' => '1.0.0'
    ]);
});

Route::post('login', [LoginController::class, 'login']);
Route::group(['middleware' => 'auth.api'], function () {
    Route::prefix('siswa')->group(function () {
        Route::post('/', [SiswaController::class, 'index']);
        Route::get('/{id}', [SiswaController::class, 'show']);
    });
    Route::prefix('guru')->group(function () {
        Route::post('/', [GuruController::class, 'index']);
        Route::get('/{id}', [GuruController::class, 'show']);
    });
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });
    Route::prefix('kelas')->group(function () {
        Route::post('/', [KelasController::class, 'index']);
        Route::get('/{id}', [KelasController::class, 'show']);
    });
    Route::prefix('mapel')->group(function () {
        Route::post('/mapelGuru', [MapelController::class, 'mapelGuru']);
        Route::post('/', [MapelController::class, 'index']);
        Route::get('/{id}', [MapelController::class, 'show']);
    });
    Route::prefix('presensi')->group(function () {
        Route::post('/checkin', [PresensiController::class, 'checkin']);
        Route::post('/checkout', [PresensiController::class, 'checkout']);
        Route::post('/countAbsensi', [PresensiController::class, 'countAbsensi']);
        Route::post('/getPresensi', [PresensiController::class, 'getPresensi']);
    });
    Route::prefix('absensi')->group(function () {
        Route::post('/storeAbsensiSiswa', [AbsensiController::class, 'storeAbsensiSiswa']);
        Route::post('/getAbsensiSiswa', [AbsensiController::class, 'getAbsensiSiswa']);
        Route::post('/storeAbsensiMapel', [AbsensiController::class, 'storeAbsensiMapel']);
        Route::post('/getAbsensiMapel', [AbsensiController::class, 'getAbsensiMapel']);
        Route::post('/rekapAbsensiSiswa', [AbsensiController::class, 'rekapAbsensiSiswa']);
        Route::post('/countAbsensiSiswa', [AbsensiController::class, 'countAbsensiSiswa']);
    });
    Route::prefix('jadwal')->group(function () {
        Route::post('/getJadwalPelajaran', [JadwalController::class, 'getJadwalPelajaran']);
    });
    Route::get('logout/{id}', [LoginController::class, 'logout']);
});