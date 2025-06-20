@extends('app.template')

@section('content')

<a href="{{ url('surat_keluar') }}" class="btn btn-secondary mb-3">
    <i class="ti ti-arrow-left"></i> Kembali
</a>

<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="mb-4 text-primary">
            <i class="ti ti-mail"></i> Detail Surat Keluar
        </h4>

        <div class="row">

            <div class="col-md-6">
                @if ($surat->noref !== null)   
                <div class="mb-3">
                    <strong class="text-muted">Membalas Surat :</strong><br>
                    <span class="fw-semibold"><a href="{{ url('surat_masuk/'.$surat->noref) }}">{{$surat->balasan->perihal}}</a></span>
                </div>
                @endif

                <div class="mb-3">
                    <strong class="text-muted">Tipe Surat:</strong><br>
                    <span class="fw-semibold">{{ ucfirst($surat->tipe ?? '-') }}</span>
                </div>

                <div class="mb-3">
                    <strong class="text-muted">Ditujukan:</strong><br>
                    <span class="fw-semibold">{{ $surat->penerima->nama_bagian ?? '-' }}</span>
                </div>

                <div class="mb-3">
                    <strong class="text-muted">Sifat:</strong><br>
                    <span class="badge bg-info text-white">{{ ucfirst($surat->sifat) }}</span>
                </div>

                <div class="mb-3">
                    <strong class="text-muted">Lampiran:</strong><br>
                    <span class="fw-semibold">{{ $surat->lampiran ?? '-' }}</span>
                </div>

                <div class="mb-3">
                    <strong class="text-muted">Perihal:</strong><br>
                    <span class="fw-semibold">{{ $surat->perihal }}</span>
                </div>

                <div class="mb-3">
                    <strong class="text-muted">Tanggal Surat:</strong><br>
                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($surat->tgl_surat)->translatedFormat('d F Y') }}</span>
                </div>
            </div>

            <div class="col-md-6">
                <strong class="text-muted mb-3 d-block">Riwayat Status Surat:</strong>
                <div class="timeline">
                    @forelse ($status_surat as $value)
                        <div class="timeline-item d-flex">
                            <div class="timeline-icon flex-shrink-0">
                                <i class="ti ti-circle-check text-{{ $value->color }}"></i>
                            </div>
                            <div class="timeline-content ms-3">
                                <span class="fw-semibold">{{ $value->status }}</span><br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($value->created_at)->translatedFormat('d M Y, H:i') }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada riwayat status.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="mb-3">
            <strong class="text-muted">Preview File Surat:</strong>
            <div class="border rounded shadow-sm mt-2">
                <iframe 
                    src="{{ asset('storage/' . $surat->file) }}" 
                    width="100%" 
                    height="500px"
                    style="border:none;">
                </iframe>
            </div>
            <a href="{{ url('surat_keluar/download', $surat->id) }}" class="btn btn-outline-primary mt-3">
                <i class="ti ti-download"></i> Download File
            </a>
        </div>
    </div>
</div>

<style>
.timeline {
    border-left: 2px solid #dee2e6;
    padding-left: 15px;
    margin-top: 10px;
    position: relative;
}
.timeline-item {
    margin-bottom: 1.5rem;
    position: relative;
}
.timeline-icon {
    width: 20px;
    height: 20px;
    margin-left: -32px;
    margin-top: 2px;
}
.timeline-icon i {
    font-size: 16px;
}
</style>

@endsection
