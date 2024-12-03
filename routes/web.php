<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JenisCutiController;
use App\Http\Controllers\KonfigCutiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengajuanCutiController;
use App\Http\Controllers\RekapCutiPegawaiController;
use App\Http\Controllers\RiwayatPengajuanCutiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('post_login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Routes for Authenticated Users
Route::middleware('auth')->group(function () {
    // Route::get('home', function () {
    //     return view('pages.staff_admin.dashboard.index');
    // })->name('home');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Staff Admin Routes with prefix 'admin'
    Route::prefix('admin')->middleware(['role:staff admin'])->group(function () {
        Route::resource('jabatan', JabatanController::class);
        Route::resource('konfig_cuti', KonfigCutiController::class);
        Route::resource('jenis_cuti', JenisCutiController::class);
        Route::resource('pegawai', PegawaiController::class);
        Route::post('pegawai/{id}/reset-password', [PegawaiController::class, 'resetPassword'])->name('pegawai.resetPassword');

        Route::resource('pengajuan-cuti', PengajuanCutiController::class);
        Route::patch('/pengajuan-cuti/{id}/verifikasi', [PengajuanCutiController::class, 'verifikasi'])->name('pengajuan-cuti.verifikasi');
        Route::patch('/pengajuan-cuti/{id}/revisi', [PengajuanCutiController::class, 'revisi'])->name('pengajuan-cuti.revisi');
        Route::patch('/pengajuan-cuti/{id}/tolak', [PengajuanCutiController::class, 'tolak'])->name('pengajuan-cuti.tolak');

        Route::get('/rekap-cuti', [RekapCutiPegawaiController::class, 'index'])->name('rekap-cuti');
        // Route::get('/rekap-cuti/{id}', [RekapCutiPegawaiController::class, 'show'])->name('rekap-cuti.detail');
        Route::get('/rekap-cuti/{id}/{tahun?}', [RekapCutiPegawaiController::class, 'show'])->name('rekap-cuti.detail');
    });

    // Direktur Routes with prefix 'direktur'
    Route::prefix('direktur')->middleware(['role:direktur'])->group(function () {
        Route::get('/pengajuan-cuti', [PengajuanCutiController::class, 'indexDirektur'])->name('direktur.pengajuan-cuti');
        Route::get('/pengajuan-cuti/{id}', [PengajuanCutiController::class, 'detailDirektur'])->name('direktur.detail-pengajuan-cuti');
        Route::patch('/pengajuan-cuti/{id}/setujui', [PengajuanCutiController::class, 'setujuiDirektur'])->name('direktur.setujui-pengajuan-cuti');
        Route::patch('/pengajuan-cuti/{id}/tolak', [PengajuanCutiController::class, 'tolakDirektur'])->name('direktur.tolak-pengajuan-cuti');
    });

    // Pegawai Routes
    Route::middleware(['role:pegawai'])->group(function () {
        Route::get('/form-pengajuan-cuti', [PengajuanCutiController::class, 'showFormPengajuan'])->name('pegawai.pengajuan-cuti');
        Route::post('/form-pengajuan-cuti', [PengajuanCutiController::class, 'pengajuanCuti'])->name('post.pengajuan-cuti');
        Route::get('/riwayat-cuti', [RiwayatPengajuanCutiController::class, 'index'])->name('pegawai.riwayat-cuti');
    });
});
