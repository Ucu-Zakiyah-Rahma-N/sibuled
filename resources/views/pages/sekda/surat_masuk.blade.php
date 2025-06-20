@extends('app.template')

@section('content')

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    {{ session()->forget('success') }}
@endif
@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    {{ session()->forget('error') }}
@endif

<div class="card shadow-sm rounded">
  <div class="card-header">
    <div class="d-flex justify-content-between align-items-center mb-0">
      <h5 class="card-title mb-0 fw-bold">Filter Surat</h5>
      <div class="d-flex">
        <button class="btn btn-secondary me-2" id="resetFilter">Reset</button>
        <button class="btn btn-primary" id="toggleFilter">Show/Hide</button>
      </div>
    </div>
  </div>
  <div class="card-body" id="filterBody" style="display: none;">
    <form method="GET" action="{{ url('surat_masuk') }}" id="filterForm">
      <div class="row g-3 mb-3">
        <div class="col-md-3">
          <label for="startDate" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
          <input type="date" class="form-control" id="startDate" name="startDate"
            value="{{ $request->startDate }}">
        </div>
        <div class="col-md-3">
          <label for="endDate" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
          <input type="date" class="form-control" id="endDate" name="endDate"
            value="{{ $request->endDate }}">
        </div>
        <div class="col-md-6">
          <label for="jenisSurat" class="form-label">Bagian <span class="text-danger">*</span></label>
          <select class="form-select" id="bagian" name="bagian">
            <option value="">Semua Bagian</option>
            @foreach ($bagian as $value)
              <option value="{{ $value->id }}" {{ $request->bagian == $value->id ? 'selected' : '' }}>
                {{ $value->nama_bagian }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <label for="nomor" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="nomor" name="nomor" value="{{ $request->nomor }}">
        </div>
        <div class="col-md-6">
          <label for="tipeSurat" class="form-label">Tipe Surat <span class="text-danger">*</span></label>
          <select class="form-select" id="tipeSurat" name="tipe">
            <option value="">Semua Tipe Surat</option>
            <option value="umum" {{ $request->tipe == 'umum' ? 'selected' : '' }}>Umum</option>
            <option value="permohonan" {{ $request->tipe == 'permohonan' ? 'selected' : '' }}>Permohonan</option>
          </select>
        </div>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary px-4">Cari</button>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#toggleFilter').click(function() {
      $('#filterBody').slideToggle();
    });

    $('#resetFilter').click(function() {
      $('#filterForm')[0].reset();
      window.location.href = "{{ url('surat_masuk') }}";
    });
  });
</script>

<div class="card mt-4">
    <div class="card-body table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Surat</th>
                    <th>Nomor Surat</th>
                    <th>Tipe Surat</th>
                    <th>Perihal</th>
                    <th>Pengirim</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($surat_masuk->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center py-4">Tidak ada surat masuk.</td>
                    </tr>
                @else
                    @php
                        $currentPage = $surat_masuk->currentPage();
                        $perPage = $surat_masuk->perPage();
                        $no = ($currentPage - 1) * $perPage + 1;
                    @endphp
                    @foreach ($surat_masuk as $value)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $value->tgl_surat }}</td>
                            <td>{{ $value->nomor }}</td>
                            <td>{{ $value->tipe }}</td>
                            <td>{{ $value->perihal }}</td>
                            <td>{{ $value->pengirim->nama_bagian }}</td>
                            <td><span class="badge rounded-pill text-bg-{{ $value->statusTerakhir->color }}">{{ $value->statusTerakhir->status }}</span></td>
                            <td>
                                @if ($value->tgl_diterima === null)
                                    <a href="{{ url('surat_masuk/diterima/' . $value->id) }}" class="btn btn-success btn-sm">Terima</a>
                                @else
                                    <div class="dropdown">
                                        <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Opsi
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ url('surat_masuk/' . $value->id) }}">Detail</a></li>
                                            @if ($value->dibalas === null && $value->tipe === 'umum')
                                                <li><a class="dropdown-item" href="{{ url('surat_masuk/balas/' . $value->id) }}">Balas Surat</a></li>
                                            @endif
                                            @if ($value->disposisiSekda === null && $value->tipe === 'permohonan')
                                                <li><a class="dropdown-item" href="{{ url('sekda/disposisi/create/' . $value->id) }}">Disposisikan</a></li>
                                            @elseif ($value->disposisiSekda !== null && $value->tipe === 'permohonan')
                                                <li><a class="dropdown-item" href="{{ url('sekda/disposisi/view/' . $value->disposisiSekda->id) }}">Lihat Lembar Disposisi</a></li>
                                            @endif
                                            {{-- Assuming you need more Sekda-specific actions here based on your previous examples --}}
                                            {{-- If there are actions like "Terima Disposisi Asda/Kabag/BUMD" for Sekda, they would go here --}}
                                            @if ($value->disposisiAsda && $value->disposisiAsda->tgl_diterima === null)
                                                <li><a class="dropdown-item" href="{{ url('sekda/disposisi_asda/diterima/' . $value->disposisiAsda->id) }}">Terima Disposisi Asda</a></li>
                                            @endif
                                            @if ($value->kartuDisposisi && $value->kartuDisposisi->tgl_diterima_sekda === null)
                                                 <li><a class="dropdown-item" href="{{ url('sekda/kartu_disposisi/diterima/' . $value->kartuDisposisi->id) }}">Terima Kartu Disposisi</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex justify-content-center">
        {{ $surat_masuk->links() }}
    </div>
</div>

@endsection