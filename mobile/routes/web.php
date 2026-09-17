<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
    Route::get('/', [LoginController::class, 'index']);
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('customLogin', [LoginController::class, 'customLogin'])->name('customLogin');
    Route::get('signOut', [LoginController::class, 'signOut'])->name('signOut');
    Route::get('loginMobile', [LoginController::class, 'loginMobile'])->name('loginMobile');
    Route::post('customLoginMobile', [LoginController::class, 'customLoginMobile'])->name('customLoginMobile');
    Route::get('signOutMobile', [LoginController::class, 'signOutMobile'])->name('signOutMobile');
    Route::get('settings', [LoginController::class, 'settings'])->name('settings');
    Route::post('updateEmail', [LoginController::class, 'updateEmail'])->name('updateEmail');
    Route::post('updatePassword', [LoginController::class, 'updatePassword'])->name('updatePassword');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('dashboard', 'index')->name('dashboard');
    Route::get('viewJadwal', 'viewJadwal')->name('viewJadwal');
    Route::post('showJadwal', 'showJadwal')->name('showJadwal');
});

Route::controller(AbsensiController::class)->group(function () {
    Route::get('scan', 'index')->name('scan');
    Route::post('scanMasuk', 'scanMasuk')->name('scanMasuk');
    Route::post('scanPulang', 'scanPulang')->name('scanPulang');

    Route::get('viewPresensi', 'viewPresensi')->name('viewPresensi');
    Route::post('showPresensi', 'showPresensi')->name('showPresensi');

    Route::get('viewAbsensiSiswa', 'viewAbsensiSiswa')->name('viewAbsensiSiswa');
    Route::post('showAbsensiSiswa', 'showAbsensiSiswa')->name('showAbsensiSiswa');
    Route::post('createAbsensiSiswa', 'createAbsensiSiswa')->name('createAbsensiSiswa');

    Route::get('viewAbsensiMapel', 'viewAbsensiMapel')->name('viewAbsensiMapel');
    Route::post('showAbsensiMapel', 'showAbsensiMapel')->name('showAbsensiMapel');
    Route::post('createAbsensiMapel', 'createAbsensiMapel')->name('createAbsensiMapel');

    Route::get('rekapAbsensiSiswa', 'rekapAbsensiSiswa')->name('rekapAbsensiSiswa');
    Route::post('showRekapAbsensiSiswa', 'showRekapAbsensiSiswa')->name('showRekapAbsensiSiswa');
    Route::get('rekapAbsensiMapel', 'rekapAbsensiMapel')->name('rekapAbsensiMapel');
    Route::post('showRekapAbsensiMapel', 'showRekapAbsensiMapel')->name('showRekapAbsensiMapel');
});

Route::controller(MapelController::class)->group(function () {
    Route::get('viewMapel', 'index')->name('viewMapel');
    Route::get('tambahMapel', 'create')->name('tambahMapel');
    Route::get('editMapel/{id}', 'edit')->name('editMapel');
    Route::get('deleteMapel/{id}', 'delete')->name('deleteMapel');
    Route::post('storeMapel', 'store')->name('storeMapel');
    Route::post('updateMapel', 'update')->name('updateMapel');
    Route::post('showMapel', 'show')->name('showMapel');
});

Route::controller(KelasController::class)->group(function () {
    Route::get('viewKelas', 'index')->name('viewKelas');
    Route::get('tambahKelas', 'create')->name('tambahKelas');
    Route::get('editKelas/{id}', 'edit')->name('editKelas');
    Route::get('deleteKelas/{id}', 'delete')->name('deleteKelas');
    Route::post('storeKelas', 'store')->name('storeKelas');
    Route::post('updateKelas', 'update')->name('updateKelas');
    Route::post('showKelas', 'show')->name('showKelas');
});

Route::controller(SiswaController::class)->group(function () {
    Route::get('viewSiswa', 'index')->name('viewSiswa');
    Route::get('tambahSiswa', 'create')->name('tambahSiswa');
    Route::get('editSiswa/{id}', 'edit')->name('editSiswa');
    Route::get('deleteSiswa/{id}', 'delete')->name('deleteSiswa');
    Route::post('storeSiswa', 'store')->name('storeSiswa');
    Route::post('updateSiswa', 'update')->name('updateSiswa');
    Route::post('showSiswa', 'show')->name('showSiswa');
});

Route::controller(GuruController::class)->group(function () {
    Route::get('viewGuru', 'index')->name('viewGuru');
    Route::get('tambahGuru', 'create')->name('tambahGuru');
    Route::get('editGuru/{id}', 'edit')->name('editGuru');
    Route::get('deleteGuru/{id}', 'delete')->name('deleteGuru');
    Route::post('storeGuru', 'store')->name('storeGuru');
    Route::post('updateGuru', 'update')->name('updateGuru');
    Route::post('showGuru', 'show')->name('showGuru');
});
