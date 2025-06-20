<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AsdaController;
use App\Http\Controllers\BPKADController;
use App\Http\Controllers\BUMDController;
use App\Http\Controllers\KabagController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SekdaController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
use Illuminate\Support\Facades\Route;

// Group Guest
Route::middleware('guest')->group(function() {
    Route::get('/',[AppController::class, 'login'])->name('login');
    Route::post('auth',[AppController::class, 'auth']);
});

// Group Auth
Route::middleware('auth')->group(function() {
    Route::post('logout', [AppController::class, 'logout']);
    Route::get('dashboard', [AppController::class, 'dashboard']);
    Route::get('my_profile', [ProfileController::class, 'index']);
    Route::post('my_profile', [ProfileController::class, 'update']);
    Route::get('surat/{id}', [AppController::class, 'suratDetail']);

    // Surat Keluar
    Route::get('surat_keluar', [SuratKeluarController::class, 'index']);
    Route::get('surat_keluar/{id}', [SuratKeluarController::class, 'show']);
    Route::get('surat_keluar_create', [SuratKeluarController::class, 'create']);
    Route::post('surat_keluar', [SuratKeluarController::class, 'store']);
    Route::get('surat_keluar/{id}/edit', [SuratKeluarController::class, 'edit']);
    Route::put('surat_keluar/{id}', [SuratKeluarController::class, 'update']);
    Route::get('surat_keluar/download/{id}', [SuratKeluarController::class, 'download']);


    // Surat Masuk
    Route::get('surat_masuk', [SuratMasukController::class, 'index']);
    Route::get('surat_masuk/{id}', [SuratMasukController::class, 'show']);
    Route::get('surat_masuk/balas/{id}', [SuratMasukController::class, 'reply']);
    Route::post('surat_masuk/balas', [SuratMasukController::class, 'replyStore']);
    Route::get('surat_masuk/diterima/{id}', [SuratMasukController::class, 'diterima']);
    Route::get('surat_masuk/download/{id}', [SuratMasukController::class, 'download']);

    // Kabag
    Route::get('kabag/users', [KabagController::class, 'userGet']);
    Route::get('kabag/user/create', [KabagController::class, 'userCreate']);
    Route::get('kabag/user/detail/{id}', [KabagController::class, 'userDetail']);
    Route::post('kabag/user', [KabagController::class, 'userStore']);
    Route::put('kabag/user/{id}', [KabagController::class, 'userUpdate']);
    Route::delete('kabag/user/{id}', [KabagController::class, 'userDelete']);
    Route::get('kabag/ubah_password/{id}', [KabagController::class, 'ubahPassword']);
    Route::patch('kabag/update_password/{id}', [KabagController::class, 'updatePassword']);
    Route::get('kabag/kartu_disposisi/{id}', [KabagController::class, 'kartuDisposisiCreate']);
    Route::post('kabag/kartu_disposisi', [KabagController::class, 'kartuDisposisiStore']);
    Route::get('kabag/kartu_disposisi_view/{id}', [KabagController::class, 'kartuDisposisiView']);
    Route::get('kabag/disposisi_sekda/diterima/{id}', [KabagController::class, 'terimaDisposisiSekda']);
    Route::get('kabag/disposisi_asda/diterima/{id}', [KabagController::class, 'terimaDisposisiAsda']);
    Route::get('kabag/nota_dinas/create/{id}', [KabagController::class, 'notaDinasCreate']);
    Route::post('kabag/nota_dinas/upload', [KabagController::class, 'notaDinasStore']);
    Route::get('kabag/finish/{id}', [KabagController::class, 'finish']);
    Route::get('kabag/kartu_disposisi/print/{id}', [KabagController::class, 'printPdf']);

    // Sekda
    Route::get('sekda/disposisi/create/{id}', [SekdaController::class, 'disposisiCreate']);
    Route::post('sekda/disposisi', [SekdaController::class, 'disposisiStore']);
    Route::get('sekda/disposisi/view/{id}', [SekdaController::class, 'disposisiView']);

    // Asda
    Route::get('asda/disposisi_sekda', [AsdaController::class, 'disposisiSekda']);
    Route::get('asda/disposisi_sekda/diterima/{id}', [AsdaController::class, 'terimaDisposisiSekda']);
    Route::get('asda/disposisi/create/{id}', [AsdaController::class, 'disposisiCreate']);
    Route::post('asda/disposisi/store', [AsdaController::class, 'disposisiStore']);
    Route::get('asda/disposisi/view/{id}', [AsdaController::class, 'disposisiView']);
    Route::get('asda/kartu_disposisi/diterima/{id}', [AsdaController::class, 'terimaKartuDisposisi']);
    Route::get('asda/permohonan_pencairan/{id}', [AsdaController::class, 'permohonanPencairanCreate']);
    Route::post('asda/permohonan_pencairan', [AsdaController::class, 'permohonanPencairanStore']);

    Route::get('bpkad/surat_perintah/create/{id}', [BPKADController::class, 'perintahPencairanCreate']);
    Route::post('bpkad/surat_perintah', [BPKADController::class, 'perintahPencairanStore']);

    Route::get('bumd/surat_pengakuan/create/{id}', [BUMDController::class, 'pengakuanPencairanCreate']);
    Route::post('bumd/surat_pengakuan', [BUMDController::class, 'pengakuanPencairanStore']);
});
