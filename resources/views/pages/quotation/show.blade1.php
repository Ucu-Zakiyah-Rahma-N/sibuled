@extends('app.template')

@section('content')
<div class="container-fluid">
    <div class="card shadow p-4">

        <div class="d-flex justify-content-between mb-3">
            <h4>Detail Quotation / SPH</h4>

            {{-- TOMBOL DOWNLOAD WORD --}}
            <a href="{{ route('quotation.word', $quotation->id) }}"
               class="btn btn-success">
                <i class="bi bi-file-earmark-word"></i> Download SPH (Word)
            </a>
        </div>

        <table class="table table-bordered">
            <tr>
                <th width="30%">Tanggal SPH</th>
                <td>{{ \Carbon\Carbon::parse($quotation->tgl_sph)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <th>Nomor SPH</th>
                <td>{{ $quotation->no_sph }}</td>
            </tr>
            <tr>
                <th>Customer</th>
                <td>{{ strtoupper($quotation->customer->nama_perusahaan) }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $quotation->detail_alamat }}</td>
            </tr>
            <tr>
                <th>Jenis Pekerjaan</th>
                <td>{{ $jenisPekerjaan }}</td>
            </tr>
            <tr>
                <th>Nama Bangunan</th>
                <td>{{ $quotation->nama_bangunan }}</td>
            </tr>
            <tr>
                <th>Fungsi Bangunan</th>
                <td>{{ $quotation->fungsi_bangunan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Lokasi</th>
                <td>{{ $lokasi }}</td>
            </tr>
            <tr>
                <th>Luas Bangunan</th>
                <td>{{ $luasBangunan }}</td>
            </tr>
            <tr>
                <th>Total Harga</th>
                <td>
                    <strong>
                        Rp {{ number_format($totalHarga, 0, ',', '.') }}
                    </strong>
                </td>
            </tr>
            <tr>
                <th>Lama Pekerjaan</th>
                <td>{{ $quotation->lama_pekerjaan }} Hari</td>
            </tr>
        </table>

        {{-- TERMIN --}}
        <h6 class="fw-bold mt-4">Termin Pembayaran</h6>
        <ul>
            @foreach(json_decode($quotation->termin_persentase ?? '[]') as $t)
                <li>Termin {{ $t->urutan }} – {{ $t->persen }}%</li>
            @endforeach
        </ul>

    </div>
</div>
@endsection
