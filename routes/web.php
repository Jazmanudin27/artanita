<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\TabunganController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
    Route::get('/', [LoginController::class, 'index']);
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('customLogin', [LoginController::class, 'customLogin'])->name('customLogin');
    Route::get('signOut', [LoginController::class, 'signOut'])->name('signOut');
});

Route::middleware(['auth', 'Admin'])->group(function () {

    Route::controller(HomeController::class)->group(function () {
        Route::get('dashboard', 'index')->name('dashboardAdmin');
        Route::post('loadAbsensiSiswaPerKelas', 'loadAbsensiSiswaPerKelas')->name('loadAbsensiSiswaPerKelas');
        Route::post('loadAbsensiSiswaPerSiswa', 'loadAbsensiSiswaPerSiswa')->name('loadAbsensiSiswaPerSiswa');
        Route::post('loadAbsensiMapel', 'loadAbsensiMapel')->name('loadAbsensiMapel');
        Route::post('loadTeguran', 'loadTeguran')->name('loadTeguran');
        Route::post('loadJadwal', 'loadJadwal')->name('loadJadwal');
    });

    Route::controller(JadwalController::class)->group(function () {
        Route::get('viewJadwal', 'viewJadwal')->name('viewJadwal');
        Route::post('updateJadwal', 'updateJadwal')->name('updateJadwal');
        Route::post('simpanJadwal', 'simpanJadwal')->name('simpanJadwal');
        Route::post('updateJam', 'updateJam')->name('updateJam');
        Route::post('showJadwal', 'showJadwal')->name('showJadwal');
        Route::post('cekData', 'cekData')->name('cekData');
    });

    Route::controller(SettingsController::class)->group(function () {
        Route::get('viewSettings', 'viewSettings')->name('viewSettings');
    });

    Route::controller(LaporanController::class)->group(function () {
        Route::get('laporanSiswa', 'laporanSiswa')->name('laporanSiswa');
        Route::post('cetakLaporanSiswa', 'cetakLaporanSiswa')->name('cetakLaporanSiswa');
        Route::get('laporanGuru', 'laporanGuru')->name('laporanGuru');
        Route::post('cetakLaporanGuru', 'cetakLaporanGuru')->name('cetakLaporanGuru');
        Route::get('laporanPresensi', 'laporanPresensi')->name('laporanPresensi');
        Route::post('cetakLaporanPresensi', 'cetakLaporanPresensi')->name('cetakLaporanPresensi');
        Route::get('laporanAbsensiSiswa', 'laporanAbsensiSiswa')->name('laporanAbsensiSiswa');
        Route::post('cetakLaporanAbsensiSiswa', 'cetakLaporanAbsensiSiswa')->name('cetakLaporanAbsensiSiswa');
        Route::get('laporanAbsensiMapel', 'laporanAbsensiMapel')->name('laporanAbsensiMapel');
        Route::post('cetakLaporanAbsensiMapel', 'cetakLaporanAbsensiMapel')->name('cetakLaporanAbsensiMapel');
        Route::get('laporanSuratAbsen', 'laporanSuratAbsen')->name('laporanSuratAbsen');
        Route::post('cetakLaporanSuratAbsen', 'cetakLaporanSuratAbsen')->name('cetakLaporanSuratAbsen');
        Route::get('laporanSuratTeguran', 'laporanSuratTeguran')->name('laporanSuratTeguran');
        Route::post('cetakLaporanSuratTeguran', 'cetakLaporanSuratTeguran')->name('cetakLaporanSuratTeguran');
        Route::get('laporanSuratDispensasi', 'laporanSuratDispensasi')->name('laporanSuratDispensasi');
        Route::post('cetakLaporanSuratDispensasi', 'cetakLaporanSuratDispensasi')->name('cetakLaporanSuratDispensasi');
        Route::get('cetakLaporanJadwal', 'cetakLaporanJadwal')->name('cetakLaporanJadwal');
        Route::post('selectKelas', 'selectKelas')->name('selectKelas');
        Route::get('laporanSapras', 'laporanSapras')->name('laporanSapras');
        Route::post('cetakLaporanSapras', 'cetakLaporanSapras')->name('cetakLaporanSapras');

    });

    Route::controller(AbsensiController::class)->group(function () {
        Route::get('viewAbsensiSiswa', 'viewAbsensiSiswa')->name('viewAbsensiSiswa');
        Route::get('tambahAbsensiSiswa', 'createAbsensiSiswa')->name('tambahAbsensiSiswa');
        Route::get('editAbsensiSiswa/{id}', 'editAbsensiSiswa')->name('editAbsensiSiswa');
        Route::get('deleteAbsensiSiswa/{id}', 'deleteAbsensiSiswa')->name('deleteAbsensiSiswa');
        Route::post('storeAbsensiSiswa', 'storeAbsensiSiswa')->name('storeAbsensiSiswa');
        Route::post('updateAbsensiSiswa', 'updateAbsensiSiswa')->name('updateAbsensiSiswa');
        Route::post('showAbsensiSiswa', 'showAbsensiSiswa')->name('showAbsensiSiswa');
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

    Route::controller(KelasController::class)->group(function () {
        Route::get('viewKelas', 'index')->name('viewKelas');
        Route::get('tambahKelas', 'create')->name('tambahKelas');
        Route::get('editKelas/{id}', 'edit')->name('editKelas');
        Route::get('deleteKelas/{id}', 'delete')->name('deleteKelas');
        Route::post('storeKelas', 'store')->name('storeKelas');
        Route::post('updateKelas', 'update')->name('updateKelas');
        Route::post('showKelas', 'show')->name('showKelas');
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

    Route::controller(BukuController::class)->group(function () {
        Route::get('viewBuku', 'index')->name('viewBuku');
        Route::get('tambahBuku', 'create')->name('tambahBuku');
        Route::get('editBuku/{id}', 'edit')->name('editBuku');
        Route::get('deleteBuku/{id}', 'delete')->name('deleteBuku');
        Route::post('storeBuku', 'store')->name('storeBuku');
        Route::post('updateBuku', 'update')->name('updateBuku');
        Route::post('showBuku', 'show')->name('showBuku');
    });

    Route::controller(SuratController::class)->group(function () {
        Route::get('viewSuratAbsen', 'indexSuratAbsen')->name('viewSuratAbsen');
        Route::get('tambahSuratAbsen', 'createSuratAbsen')->name('tambahSuratAbsen');
        Route::get('editSuratAbsen/{id}', 'editSuratAbsen')->name('editSuratAbsen');
        Route::get('deleteSuratAbsen/{id}', 'deleteSuratAbsen')->name('deleteSuratAbsen');
        Route::post('storeSuratAbsen', 'storeSuratAbsen')->name('storeSuratAbsen');
        Route::post('updateSuratAbsen', 'updateSuratAbsen')->name('updateSuratAbsen');
        Route::post('showSuratAbsen', 'showSuratAbsen')->name('showSuratAbsen');
        Route::post('approveSuratAbsen', 'approveSuratAbsen')->name('approveSuratAbsen');

        Route::get('viewSuratTeguran', 'indexSuratTeguran')->name('viewSuratTeguran');
        Route::get('tambahSuratTeguran', 'createSuratTeguran')->name('tambahSuratTeguran');
        Route::get('editSuratTeguran/{id}', 'editSuratTeguran')->name('editSuratTeguran');
        Route::get('deleteSuratTeguran/{id}', 'deleteSuratTeguran')->name('deleteSuratTeguran');
        Route::post('storeSuratTeguran', 'storeSuratTeguran')->name('storeSuratTeguran');
        Route::post('updateSuratTeguran', 'updateSuratTeguran')->name('updateSuratTeguran');
        Route::post('showSuratTeguran', 'showSuratTeguran')->name('showSuratTeguran');

        Route::get('viewSuratDispensasi', 'indexSuratDispensasi')->name('viewSuratDispensasi');
        Route::get('tambahSuratDispensasi', 'createSuratDispensasi')->name('tambahSuratDispensasi');
        Route::get('editSuratDispensasi/{id}', 'editSuratDispensasi')->name('editSuratDispensasi');
        Route::get('deleteSuratDispensasi/{id}', 'deleteSuratDispensasi')->name('deleteSuratDispensasi');
        Route::post('storeSuratDispensasi', 'storeSuratDispensasi')->name('storeSuratDispensasi');
        Route::post('updateSuratDispensasi', 'updateSuratDispensasi')->name('updateSuratDispensasi');
        Route::post('showSuratDispensasi', 'showSuratDispensasi')->name('showSuratDispensasi');

        Route::get('viewSuratUndangan', 'viewSuratUndangan')->name('viewSuratUndangan');
    });

    Route::controller(PeminjamanController::class)->group(function () {
        Route::get('viewPeminjaman', 'index')->name('viewPeminjaman');
        Route::get('tambahPeminjaman', 'create')->name('tambahPeminjaman');
        Route::get('editPeminjaman/{id}', 'edit')->name('editPeminjaman');
        Route::post('deletePeminjaman', 'delete')->name('deletePeminjaman');
        Route::post('storePeminjaman', 'store')->name('storePeminjaman');
        Route::post('updatePeminjaman', 'update')->name('updatePeminjaman');
        Route::post('showPeminjaman', 'show')->name('showPeminjaman');
        Route::post('pengembalianBuku', 'pengembalianBuku')->name('pengembalianBuku');
        Route::post('perpanjangPeminjaman', 'perpanjangPeminjaman')->name('perpanjangPeminjaman');
        Route::post('batalDikembalikan', 'batalDikembalikan')->name('batalDikembalikan');
    });

    Route::controller(SppController::class)->group(function () {
        Route::get('viewSpp', 'index')->name('viewSpp');
        Route::get('tambahSpp', 'create')->name('tambahSpp');
        Route::post('showSpp', 'show')->name('showSpp');
        Route::post('showSppTemp', 'showSppTemp')->name('showSppTemp');
        Route::post('storeSppTemp', 'storeSppTemp')->name('storeSppTemp');
        Route::post('deleteSppTemp', 'deleteSppTemp')->name('deleteSppTemp');
        Route::post('cekSppTemp', 'cekSppTemp')->name('cekSppTemp');
        Route::post('storeSpp', 'storeSpp')->name('storeSpp');
        Route::post('nobuktiSpp', 'nobuktiSpp')->name('nobuktiSpp');
        Route::post('cetakFakturSpp', 'cetakFakturSpp')->name('cetakFakturSpp');
    });

});

Route::get('/v1', function () {
    return response()->json([
        'status' => 'online',
        'app' => 'Artanita Presensi Guru Mobile API v1',
        'version' => '1.0.0',
        'timestamp' => now()->toDateTimeString()
    ]);
});

Route::get('/v1/api', function () {
    return response()->json([
        'status' => 'online',
        'app' => 'Artanita Presensi Guru Mobile API v1',
        'version' => '1.0.0',
        'timestamp' => now()->toDateTimeString()
    ]);
});


