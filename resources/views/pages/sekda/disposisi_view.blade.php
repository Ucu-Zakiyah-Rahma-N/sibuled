view lembar disposisi:

@extends('app.template')

@section('content')
<style>
  .lembar-disposisi-container {
    font-family: Arial, sans-serif;
    border: 2px solid #000;
    padding: 20px;
    width: 800px;
    margin: 40px auto;
    background-color: #fff;
  }
  .lembar-disposisi-container h2,
  .lembar-disposisi-container h3 {
    text-align: center;
    margin: 5px 0;
  }
  .lembar-disposisi-container .header {
    text-align: center;
    margin-bottom: 20px;
  }
  .lembar-disposisi-container .row {
    display: flex;
    justify-content: space-between;
    margin: 5px 0;
  }
  .lembar-disposisi-container .row label {
    width: 150px;
    font-weight: bold;
  }
  .lembar-disposisi-container .box {
    border: 1px solid #000;
    padding: 5px;
    margin-top: 10px;
  }
  .lembar-disposisi-container .signature {
    margin-top: 40px;
    text-align: right;
  }
</style>

<a class="btn btn-danger" href="{{ url('surat_masuk') }}">Kembali</a>

<div class="lembar-disposisi-container">
  <div class="header">
    <h2>PEMERINTAH KABUPATEN KARAWANG</h2>
    <h3>SEKRETARIAT DAERAH</h3>
    <p>
      Jl. Jenderal A. Yani No. 1 Karawang<br>
      Situs Web: <a href="https://setda.karawangkab.go.id" target="_blank">https://setda.karawangkab.go.id</a> |
      Surel: setda@karawangkab.go.id
    </p>
    <h3>LEMBAR DISPOSISI</h3>
  </div>

<div class="row">
  <label>Surat dari:</label>
  <span>{{ $disposisi->surat->pengirim->nama_bagian }}</span>
  <label>Diterima Tgl:</label>
  <span>{{ $disposisi->surat->tgl_diterima }}</span>
</div>
<div class="row">
  <label>No. Surat:</label>
  <span>{{ $disposisi->surat->nomor_surat }}</span>
  <label>No. Agenda:</label>
  <span>{{ $disposisi->nomor_agenda }}</span> 
</div>
<div class="row">
  <label>Tgl. Surat:</label>
  <span>{{ $disposisi->surat->tgl_surat }}</span>
  <label>Sifat:</label>
  <span>{{ $disposisi->surat->sifat }}</span>
</div>

<div class="box">
  <strong>Hal:</strong> {{ $disposisi->surat->perihal }}
</div>

<div class="box">
  <strong>Diteruskan kepada Sdr:</strong><br>
  {{ $disposisi->bagian->nama_bagian }}<br>
</div>

<div class="box">
  <strong>Dengan hormat harap:</strong><br>
  {{ $disposisi->intruksi }}
</div>

<div class="box">
  <strong>Catatan:</strong> {{ $disposisi->catatan }}
</div>

<div class="signature">
    <p><strong>SEKRETARIS DAERAH KABUPATEN KARAWANG</strong></p>
    @if (auth()->user()->profile->ttd !== null)
    <img class="mx-4" src="{{ url('storage/' . auth()->user()->profile->ttd) }}" alt="" width="100px">
    @endif
    <p><strong>H. ASEP AANG RAHMATULLAH, S.STP., M.P.</strong><br>
    Pembina Utama Muda<br>
    NIP. 19780521 199711 1 001</p>
</div>
</div>
@endsection