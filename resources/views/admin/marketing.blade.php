@extends('app.template')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center mb-0">
            <h5 class="card-title mb-0">Data Marketing</h5>
            {{-- <a href="{{ url('marketing/create') }}" class="btn btn-primary">Tambah Marketing</a> --}}
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Nama</th>
                        <th>Status</th>
                        {{-- <th style="width: 10%">Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($marketing as $m)
                        <tr>
                            <td>{{ $loop->iteration + ($marketing->currentPage() - 1) * $marketing->perPage() }}</td>
                            <td>{{ $m->nama }}</td>
                            <td>{{ ucfirst($m->status) }}</td>
                            {{-- <td>
                                <div class="dropdown">
                                    <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opsi
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Ubah Password</a></li>
                                    </ul> 
                                </div>
                            </td> --}}
                        </tr> 
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data marketing</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ✅ Pagination di kanan bawah --}}
        <div class="d-flex justify-content-end mt-3">
            {{ $marketing->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection
