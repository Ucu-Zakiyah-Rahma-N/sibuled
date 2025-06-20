<style>
  @page {
    size: A4;
    margin: 20mm 15mm 20mm 15mm; /* margin sudah pas */
  }

  body {
    font-family: Arial, sans-serif;
    background: #fff;
    margin: 0;
    padding: 0;
  }

  .kartu-disposisi-container {
    width: 140mm; /* sesuai A4 dengan margin */
    height: 220mm; /* jangan ubah */
    margin: 0 auto;
    padding: 10mm 15mm;
    border: 2px solid #000;
    background-color: #fff;
    box-sizing: border-box;
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
</style>

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
      @php
        $path = public_path('storage/' . auth()->user()->profile->ttd);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
      @endphp
      <img src="{{ $base64 }}" alt="TTD" width="100px">
      <p><strong>HJ. YAYAT ROHAYATI, MM.</strong><br>
      Pembina Utama Muda<br>
      NIP. 19671108 199303 2 003</p>
  </div>
</div>
 