@extends('app.template')

@section('content')

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 fw-semibold">Data Perizinan</h5>
            {{-- Tombol buka modal --}}
            <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus me-1"></i> Tambah Perizinan
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Jenis Perizinan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $nomor = 1; @endphp
                    @forelse ($perizinan as $p)
                        <tr>
                            <td>{{ $nomor++ }}</td>
                            <td>{{ $p->jenis }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah Perizinan --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
        <div class="modal-header bg-light text-dark rounded-top-4 border-bottom">
            <h5 class="modal-title fw-semibold" id="modalTambahLabel">
                <i class="fas fa-file-signature me-2 text-secondary"></i> Tambah Perizinan
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

            <form action="{{ route('perizinan.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="jenis" class="form-label fw-semibold">Nama Perizinan <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control form-control-lg rounded-3 @error('jenis') is-invalid @enderror"
                               id="jenis"
                               name="jenis"
                               placeholder="Masukkan nama perizinan"
                               required>
                        @error('jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-warning text-dark rounded-pill px-4 fw-semibold shadow-sm border-0" 
                    data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
