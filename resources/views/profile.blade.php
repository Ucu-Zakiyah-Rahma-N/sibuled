@extends('app.template')

@section('content')

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

<div class="card">
    <div class="card-header">
        <h4 class="card-title">PROFIL SAYA</h4>
    </div>
    <div class="card-body">
    <form action="{{ url('my_profile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $profile->nama }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="nip" class="col-sm-2 col-form-label">NIP</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="nip" name="nip" value="{{ $profile->nip }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="golongan" class="col-sm-2 col-form-label">Golongan</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="golongan" name="golongan" value="{{ $profile->golongan }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="ttd" class="col-sm-2 col-form-label">TTD</label>
            <div class="col-sm-10">
            <input type="file" class="form-control" id="ttd" name="ttd">
            </div>
        </div>
        @if ($profile->ttd !== null)
        <div class="row mb-3">
            <label for="ttd" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
            <img src="{{ asset('storage/'. $profile->ttd) }}" alt="ttd" border="1" width="100px">
            </div>
        </div>
        @else
        <div class="row mb-3">
            <label for="ttd" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
               Tanda tangan belum di tambahkan
            </div>
        </div>
        @endif
        <button type="submit" class="btn btn-success mx-0">Simpan Perubahan</button>
    </form>
    </div>
</div>

@endsection