@extends('app.template')

@section('content')

<style>
  .kartu-disposisi-container {
    font-family: Arial, sans-serif;
    border: 2px solid #000;
    padding: 20px;
    width: 800px;
    margin: 40px auto;
    background-color: #fff;
  }
  .kartu-disposisi-container h2,
  .kartu-disposisi-container h3 {
    text-align: center;
    margin: 5px 0;
  }
  .kartu-disposisi-container .header {
    text-align: center;
    margin-bottom: 20px;
  }
  .kartu-disposisi-container .row {
    display: flex;
    justify-content: space-between;
    margin: 5px 0;
  }
  .kartu-disposisi-container .row label {
    width: 150px;
    font-weight: bold;
  }
  .kartu-disposisi-container .box {
    border: 1px solid #000;
    padding: 5px;
    margin-top: 10px;
  }
  .kartu-disposisi-container .signature {
    margin-top: 40px;
    text-align: right;
  }

  .action-buttons {
    display: flex;
    justify-content: space-between;
    width: 800px;
    margin: 20px auto;
  }
</style>

@php
  $ttdExists = auth()->user()->profile && auth()->user()->profile->ttd !== null;
@endphp

<div class="action-buttons">
  <a class="btn btn-danger" href="{{ url('surat_masuk') }}">Kembali</a>
  <a 
    id="btnPrint" 
    class="btn btn-primary" 
    href="#"  {{-- pakai # supaya default href tidak langsung jalan --}}
  >Print</a>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const ttdExists = {{ $ttdExists ? 'true' : 'false' }};
    const btnPrint = document.getElementById('btnPrint');
    const printUrl = "{{ url('kabag/kartu_disposisi/print/' . $ks->id) }}";

    btnPrint.addEventListener('click', function (e) {
      e.preventDefault(); // cegah default link langsung ke printUrl
      
      if (!ttdExists) {
        // SweetAlert kalau ttd tidak ada
        Swal.fire({
          icon: 'warning',
          title: 'Tanda tangan belum tersedia',
          text: 'Silakan upload profil tanda tangan terlebih dahulu!',
          confirmButtonText: 'OK'
        });
      } else {
        // Kalau ada ttd, langsung redirect ke URL print
        window.open(printUrl, '_blank');
      }
    });
  });
</script>

<div class="kartu-disposisi-container">
  <div class="header">
    <h3>KARTU DISPOSISI</h3>
  </div>

<div class="row">
  <label>Index:</label>
  <span>{{ $ks->index }}</span>
  <label>Tanggal Penyelesaian:</label>
  <span>{{ $ks->tgl_penyelesaian }}</span>
<label>Diterima Tgl:</label>
<span>{{ $ks->surat->tgl_diterima }}</span>
</div>

<div class="row">
  <label>Dari:</label>
  <span>{{ $ks->surat->pengirim->nama_bagian }}</span>
    <label>Perihal:</label>
  <span>{{ $ks->surat->perihal }}</span>
    <label>Tgl. Surat:</label>
  <span>{{ $ks->surat->tgl_surat }}</span>
</div>

<div class="row">
  <label>No. Surat:</label>
  <span>{{ $ks->surat->nomor }}</span>
</div>

<div class="row">
  <label>Intruksi / Informasi:</label>
  <span>{{ $ks->keputusan }}</span>
  <label>Diteruskan Kepada:</label>
  <span>{{ $ks->diteruskan }}</span>
</div>

<div class="box">
  <strong>Catatan: </strong> {{ $ks->catatan }} 
</div>

<div class="signature">
    <p><strong>KEPALA BAGIAN PEREKONOMIAN DAN SDM KABUPATEN KARAWANG</strong></p>
    <img class="mx-4" src="{{ url('storage/' . auth()->user()->profile->ttd) }}" alt="" width="100px">
    <p><strong>HJ. YAYAT ROHAYATI, MM.</strong><br>
    Pembina Utama Muda<br>
    NIP. 19671108 199303 2 003</p>
  </div>
@endsection
