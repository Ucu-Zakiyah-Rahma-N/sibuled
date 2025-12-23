<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\CatatanController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\POController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\PerizinanController;
use App\Http\Controllers\RekapController;
use App\Models\Marketing;
use Illuminate\Support\Facades\Route;

// Guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/', [AppController::class, 'login'])->name('login');   // form login
    Route::post('/auth', [AppController::class, 'auth'])->name('auth'); // proses login
});

// Auth (sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AppController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AppController::class, 'logout'])->name('logout');

    //marketing
    Route::get('marketing', [MarketingController::class, 'index'])->name('marketing.index');
    //jenis perizinan

    Route::get('perizinan', [PerizinanController::class, 'index'])->name('perizinan.index');
    Route::get('perizinan/create', [PerizinanController::class, 'create'])->name('perizinan.create');
    Route::post('perizinan', [PerizinanController::class, 'store'])->name('perizinan.store');

    //wilayah   
    Route::get('/wilayah/provinsi', [WilayahController::class, 'getProvinsi']);
    Route::get('/wilayah/kabupaten/{provinsiKode}', [WilayahController::class, 'getKabupaten']);
    Route::get('/wilayah/desa/{kecamatanKode}', [WilayahController::class, 'getDesa']);
    Route::get('kawasan/{kabupatenKode}', [WilayahController::class, 'getKawasan']);

    //customer
    Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('customer/create', [CustomerController::class, 'create']);
    Route::post('customer', [CustomerController::class, 'store']);
    Route::post('customer/{id}/set-pic-utama', [CustomerController::class, 'setPicUtama'])->name('customer.setPicUtama');
    Route::get('customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('customer/update/{id}', [CustomerController::class, 'update']);
    //dashboard customer
    Route::get('/tracking', [CustomerController::class, 'tracking'])
        ->middleware(['auth', 'customer'])
        ->name('tracking');

    Route::get('/show_customer/{id}', [CustomerController::class, 'show_customer'])->name('show_customer');

    //user
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('user/create', [UserController::class, 'create']);
    Route::get('/customer/search', [UserController::class, 'search'])->name('customer.search');
    Route::post('user', [UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{id}', [UserController::class, 'edit']);
    Route::put('userupdate/{id}', [UserController::class, 'update']);
    Route::delete('user/{id}', [UserController::class, 'destroy']);
    Route::get('ubah_password/{id}', [UserController::class, 'ubahPassword']);
    Route::patch('update_password/{id}', [UserController::class, 'updatePassword']);

    //quotation
    Route::get('quotation', [QuotationController::class, 'index'])->name('quotation.index');
    Route::get('quotation/create', [QuotationController::class, 'create'])->name('quotation.create');
    Route::get('customer/{id}/get-customer', [QuotationController::class, 'getCustomer'])->name('get-customer');
    Route::get('/quotation/preview-sph/{id}', [QuotationController::class, 'previewSph']);
    Route::post('quotation', [QuotationController::class, 'store'])->name('quotation.store');

    Route::get('/templateSPH', [QuotationController::class, 'templateIndex'])->name('template.index');
    Route::post('/templates', [QuotationController::class, 'storeTemplateSPH'])->name('templates.store');
    Route::post('/templates/upload/{id}', [QuotationController::class, 'uploadTemplateSPH'])->name('templates.upload');
    Route::post('/templates/update/{id}', [QuotationController::class, 'updateTemplateSPH'])->name('templates.update');
    Route::get('/download/{id}', [QuotationController::class, 'downloadTemplateSPH'])->name('templates.download');

    Route::get('quotation/{id}/show', [QuotationController::class, 'show'])->name('quotation.show');
    Route::get('/quotation/download/{id}', [QuotationController::class, 'download'])->name('quotation.download');


    Route::get('quotation/edit/{id}', [QuotationController::class, 'edit'])->name('quotation.edit');
    Route::put('quotation/update/{id}', [QuotationController::class, 'update'])->name('quotation.update');
    Route::delete('quotation/{id}', [QuotationController::class, 'destroy'])->name('quotation.destroy');
    Route::get('/quotation/by-customer/{id}', [QuotationController::class, 'getByCustomer']);
    // Route::get('quotation/print/{id}', [QuotationController::class, 'printPdf'])->name('quotation.print');
    // Route::get('quotation/download/{id}', [QuotationController::class, 'downloadPdf'])->name('quotation.download');

    //PO
    Route::get('PO', [POController::class, 'index'])->name('PO.index');
    Route::get('PO/create', [POController::class,    'create']);
    Route::post('PO', [POController::class, 'store'])->name('PO.store');
    Route::post('/PO/verify-bast/{id}', [POController::class, 'verifyBast'])->name('po.verifyBast');
    Route::get('/files/{filename}', function ($filename) {
        $path = storage_path('app/public/' . $filename);
        if (!file_exists($path)) abort(404);
        return response()->file($path);
    })->name('files.view')->where('filename', '.*');


    Route::get('rekap_marketing', [RekapController::class, 'rekapBulanan'])->name('rekap.bulanan');
    Route::get('/achievement', [RekapController::class, 'achievement'])->name('achievement');
    Route::post('/achievement/save', [RekapController::class, 'saveTarget'])->name('achievement.save');


    // projek
    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('projects/create/{id}', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
    // Route::get('projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('projects/verifikasi/{po_id}', [ProjectController::class, 'verifikasi'])->name('projects.verifikasi');
    Route::put('/projects/update/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::post('/projects/update-progress/{projectTahapanId}', [ProjectController::class, 'updateProgress'])->name('projects.updateProgress');
    Route::post('/projects/{projectId}/tambah-tahapan-opsional', [ProjectController::class, 'tambahTahapanOpsional'])->name('tahapan.opsional.store');

    //menu timeline
    Route::middleware([
        'auth',
        'role:superadmin,admin 1,admin 2,CEO,direktur,admin marketing,manager projek,manager finance,manager marketing'
    ])->group(function () {
        Route::get('/admin/timeline', [ProjectController::class, 'timeline'])
            ->name('projects.timeline');
    });

    Route::middleware([
        'auth',
        'role:customer'
    ])->group(function () {
        Route::get('/customer/timeline', [ProjectController::class, 'timelineCustomer'])
            ->name('customer.timeline');
    });
    Route::get('/timeline/export/pdf', [ProjectController::class, 'exportTimelinePdf'])->name('timeline.export.pdf');
    Route::post('/timeline/update-event', [ProjectController::class, 'updateEvent']);

    // verifikasi/tracking
    Route::patch('/projects/verifikasi/dokumen/{projectPerizinanId}/{ceklisId}', [VerifikasiController::class, 'verifikasiDokumen'])->name('projects.verifikasi.dokumen');
    Route::patch('/projects/verifikasi/tahapan/{projectPerizinanId}', [VerifikasiController::class, 'verifikasiTahapan'])->name('projects.verifikasi.tahapan');
    // Route::post('/projects/update-progress/{projectTahapanId}', [ProjectController::class, 'updateProgress'])->name('projects.updateProgress');
    Route::post('project/ceklis_exclude', [VerifikasiController::class, 'exclude'])->name('project.ceklis.exclude');

    // Route::get('verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
    // Route::post('/verifikasi/{id}', [VerifikasiController::class, 'update'])->name('verifikasi.update');

    // catatan
    Route::post('/catatan', [CatatanController::class, 'store'])->name('catatan.store');
});
