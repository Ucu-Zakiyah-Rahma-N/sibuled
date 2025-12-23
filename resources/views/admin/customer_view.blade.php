@extends('app.template')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center mb-0">
            <h5 class="card-title mb-0">Data Customer</h5>
            <a href="{{ url('customer/create') }}" class="btn btn-primary fw-semibold rounded-pill px-3">
                 <i class="bi bi-plus-circle me-1"></i>Tambah Customer</a>
        </div>
    </div>

    <div class="card-body table-responsive">
                            @php
                        $no = ($customer->currentPage() - 1) * $customer->perPage() + 1;
                    @endphp

        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th rowspan="2" class="align-middle">No</th>
                    <th rowspan="2" class="align-middle">Nama Perusahaan</th>
                    <th colspan="3" class="align-middle bg-light fw-semibold text-dark">Lokasi</th>
                    <th colspan="2" class="align-middle bg-light fw-semibold text-dark">PIC Marketing</th>
                    <th colspan="3" class="align-middle bg-light fw-semibold text-dark">PIC Perusahaan</th>
                    <th rowspan="2" class="align-middle">Aksi</th>
                </tr>
                <tr>
                    <th>Kabupaten</th>
                    <th>Kawasan</th>
                    <th>Detail Alamat</th>
                    <th>Status</th>
                    <th>Nama</th>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($customer as $c)
 @php
                        // decode json pic_perusahaan
                        $picList = is_string($c->pic_perusahaan)
                            ? json_decode($c->pic_perusahaan, true)
                            : $c->pic_perusahaan;

                        // cari PIC utama
                        $utama = collect($picList ?? [])->firstWhere('utama', true);
                    @endphp

                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $c->nama_perusahaan }}</td>
                        <td>{{ $c->kabupaten_name ?? '-' }}</td>
                        <td>{{ $c->kawasan_industri->nama_kawasan ?? '-' }}</td>
                        <td>{{ $c->detail_alamat ?? '-' }}</td>
                        <td>{{ $c->marketing->status ?? '-' }}</td>
                        <td>{{ $c->marketing->nama ?? '-' }}</td>

                        @if($utama)
                            <td>{{ $utama['nama'] ?? '-' }}</td>
                            <td>{{ $utama['kontak'] ?? '-' }}</td>
                            <td>{{ $utama['email'] ?? '-' }}</td>
                        @else
                            <td colspan="3" class="text-center"><em>Tidak ada PIC utama</em></td>
                        @endif

                        <td class="text-center">
                            <a href="{{ route('customer.edit', $c->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3 d-flex justify-content-end">
        {{ $customer->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
