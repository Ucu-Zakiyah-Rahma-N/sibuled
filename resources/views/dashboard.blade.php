@extends('app.template')

@section('content')

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'berhasil masuk',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    {{ session()->forget('success') }}
@endif

<div class="card mb-3">
    <div class="card-body">
    <p class="mb-0">Selamat Datang <b>{{ auth()->user()->profile->nama }}</b></p>
    </div>
</div>

<div class="row">
    <!-- Surat Masuk -->
    <div class="col-md-6 mb-4">
        <div class="card shadow border-0">
            <div class="card-body d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="ti ti-mail fs-4"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted">Surat Masuk</h6>
                    <h4 class="fw-bold mb-0">{{ $jumlahSuratMasuk ?? 0 }}</h4>
                    <small class="text-primary"><i class="ti ti-arrow-down-left"></i> diterima</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Surat Keluar -->
    <div class="col-md-6 mb-4">
        <div class="card shadow border-0">
            <div class="card-body d-flex align-items-center">
                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="ti ti-mail-forward fs-4"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted">Surat Keluar</h6>
                    <h4 class="fw-bold mb-0">{{ $jumlahSuratKeluar ?? 0 }}</h4>
                    <small class="text-success"><i class="ti ti-arrow-up-right"></i> dikirim</small>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection