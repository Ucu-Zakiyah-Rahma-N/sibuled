@extends('app.template')

@section('content')
<div class="container-fluid">
    <div class="card p-3">
        <h4>Daftar Template SPH</h4>

        {{-- TOMBOL CREATE TEMPLATE --}}
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-circle"></i> Tambah Template
        </button>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama Template</th>
                    <th>Upload / Update</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                @foreach($templates as $t)
                    <tr>
                        <td>{{ $t->nama_template }}</td>

                        {{-- UPLOAD / UPDATE --}}
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $t->id }}">
                                <i class="bi bi-upload"></i> Upload
                            </button>

                            {{-- Modal Upload --}}
                            <div class="modal fade" id="uploadModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">Upload Template: {{ $t->nama_template }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                  </div>
                                  <form action="{{ route('templates.upload', $t->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="file" name="file" accept=".docx" class="form-control" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-warning">Upload</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                        </td>

                        {{-- DOWNLOAD --}}
                        <td>
                            <a href="{{ route('templates.download', $t->id) }}" class="btn btn-success btn-sm">
                                <i class="bi bi-download"></i> Download
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL CREATE TEMPLATE --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Template Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('templates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Kode Template / Perizinan</label>
                <select name="kode_template" class="form-control">
                    <option value="">-- Pilih Kode --</option>
                    @foreach($perizinans as $p)
                        <option value="{{ $p->kode }}">{{ $p->kode }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Template</label>
                <input type="text" name="nama_template" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">File Word (.docx)</label>
                <input type="file" name="file" accept=".docx" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
