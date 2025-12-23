@extends('app.template')

@section('content')
<div class="container">
    <h3>Tracking Surat</h3>

<div class="card shadow-sm rounded">
  <div class="card-header">
    <div class="d-flex justify-content-between align-items-center mb-0">
      <h5 class="card-title mb-0 fw-bold">Filter Tracking Surat</h5>
      <div class="d-flex">
        <button class="btn btn-secondary me-2" id="resetFilter">Reset</button>
        <button class="btn btn-primary" id="toggleFilter">Show/Hide</button>
      </div>
    </div>
  </div>
  <div class="card-body" id="filterBody" style="display: none;">
    <form method="GET" action="{{ url('kabag/tracking') }}" id="filterForm">
      <div class="row g-3 mb-3">
        <div class="col-md-3">
          <label for="startDate" class="form-label">Tanggal Mulai</label>
          <input type="date" class="form-control" id="startDate" name="startDate"
            value="{{ request('startDate') }}">
        </div>
        <div class="col-md-3">
          <label for="endDate" class="form-label">Tanggal Selesai</label>
          <input type="date" class="form-control" id="endDate" name="endDate"
            value="{{ request('endDate') }}">
        </div>
        <div class="col-md-6">
          <label for="bagian" class="form-label">Bagian Pengirim</label>
          <select class="form-select" id="bagian" name="bagian">
            <option value="">Semua Bagian</option>
            @foreach ($bagian as $value)
              <option value="{{ $value->id }}" {{ request('bagian') == $value->id ? 'selected' : '' }}>
                {{ $value->nama_bagian }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <label for="nomor" class="form-label">Nomor Surat</label>
          <input type="text" class="form-control" id="nomor" name="nomor" value="{{ request('nomor') }}">
        </div>
        <div class="col-md-6">
          <label for="tipeSurat" class="form-label">Tipe Surat</label>
          <select class="form-select" id="tipeSurat" name="tipe">
            <option value="">Semua Tipe Surat</option>
            <option value="umum" {{ request('tipe') == 'umum' ? 'selected' : '' }}>Umum</option>
            <option value="permohonan" {{ request('tipe') == 'permohonan' ? 'selected' : '' }}>Permohonan</option>
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
  $(document).ready(function () {
    $('#toggleFilter').click(function () {
      $('#filterBody').slideToggle();
    });

    $('#resetFilter').click(function () {
      $('#filterForm')[0].reset();
      window.location.href = "{{ url('kabag/tracking') }}";
    });
  });
</script>
<div class="table-responsive">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>       
                <th>Nomor Surat</th>
                <th>Tipe</th>
                <th>Perihal</th>
                <th>Sifat</th>
                <th>Pengirim</th>
                <th>Status Terakhir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($suratList as $index => $surat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $surat->tgl_surat }}</td>
                    <td>{{ $surat->nomor }}</td>
                    <td>{{ $surat->tipe }}</td>                    
                    <td>{{ $surat->perihal }}</td>
                    <td>{!! $surat->badge_sifat !!}</td>
                    <td>{{ $surat->pengirim->nama_bagian ?? '-' }}</td>
                    <td>
                        @if ($surat->status->isNotEmpty())
                            <span class="badge bg-{{ $surat->status->last()->color }}">
                                {{ $surat->status->last()->status }}
                            </span>
                        @else
                            <span class="badge bg-secondary">Belum ada status</span>
                        @endif
                    </td>
                    <td><a class="" href="{{ url('kabag/show_tracking/' . $surat->id) }}">Detail</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada surat keluar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
        <div class="mt-3">
        {{ $suratList->links() }}
    </div>
</div>
@endsection
