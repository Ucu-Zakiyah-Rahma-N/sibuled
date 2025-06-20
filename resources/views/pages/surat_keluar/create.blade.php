@extends('app.template')

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ url('surat_keluar') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Tipe Surat --}}
            @if (auth()->user()->bagian->nama_organisasi == 'BUMD')
                <div class="mb-3">
                    <label for="tipe" class="form-label">Tipe <span class="text-danger">*</span></label>
                    <select class="form-select @error('tipe') is-invalid @enderror" name="tipe" id="tipe">
                        <option value="" disabled {{ old('tipe') ? '' : 'selected' }}>-- pilih tipe surat --</option>
                        <option value="umum" {{ old('tipe') == 'umum' ? 'selected' : '' }}>Umum</option>
                        <option value="permohonan" {{ old('tipe') == 'permohonan' ? 'selected' : '' }}>Permohonan</option>
                    </select>
                    @error('tipe')
                        <div class="invalid-feedback">{{ $error }}</div>
                    @enderror
                </div>
            @else
                <input type="hidden" name="tipe" id="tipe" value="umum">
            @endif


            {{-- Ditujukan --}}
            <div class="mb-3">
                <label for="ditujukan" class="form-label">Ditujukan <span class="text-danger">*</span></label>
                <select class="form-select @error('ditujukan') is-invalid @enderror" name="ditujukan" id="ditujukan">
                    <option value="" disabled {{ old('ditujukan') ? '' : 'selected' }}>-- pilih penerima surat --</option>
                    @foreach ($bagian as $value)
                        <option 
                            value="{{ $value->id }}" 
                            data-id="{{ $value->id }}" 
                            {{ old('ditujukan') == $value->id ? 'selected' : '' }}>
                            {{ $value->nama_bagian }}
                        </option>
                    @endforeach
                </select>
                @error('ditujukan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- nomor --}}
            <div class="mb-3">
                <label for="nomor" class="form-label">nomor <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nomor') is-invalid @enderror" id="nomor" name="nomor" value="{{ old('nomor') }}">
                @error('nomor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Sifat --}}
            <div class="mb-3">
                <label for="sifat" class="form-label">Sifat <span class="text-danger">*</span></label>
                <select class="form-select @error('sifat') is-invalid @enderror" name="sifat">
                    <option value="" disabled {{ old('sifat') ? '' : 'selected' }}>-- pilih sifat surat --</option>
                    <option value="biasa" {{ old('sifat') == 'biasa' ? 'selected' : '' }}>Biasa</option>
                    <option value="penting" {{ old('sifat') == 'penting' ? 'selected' : '' }}>Penting</option>
                    <option value="segera" {{ old('sifat') == 'segera' ? 'selected' : '' }}>Segera</option>
                    <option value="amat segera" {{ old('sifat') == 'amat segera' ? 'selected' : '' }}>Amat Segera</option>
                </select>
                @error('sifat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Lampiran --}}
            <div class="mb-3">
                <label for="lampiran" class="form-label">Lampiran <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('lampiran') is-invalid @enderror" id="lampiran" name="lampiran" value="{{ old('lampiran') }}">
                @error('lampiran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Perihal --}}
            <div class="mb-3">
                <label for="perihal" class="form-label">Perihal <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('perihal') is-invalid @enderror" id="perihal" name="perihal" value="{{ old('perihal') }}">
                @error('perihal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Surat --}}
            <div class="mb-3">
                <label for="tgl_surat" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tgl_surat') is-invalid @enderror" id="tgl_surat" name="tgl_surat" value="{{ old('tgl_surat') }}">
                @error('tgl_surat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- File Surat --}}
            <div class="mb-3">
                <label for="file" class="form-label">File <span class="text-danger">*</span></label>
                <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
                @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Buat Surat Keluar</button>
        </form>
    </div>
</div>

<script>
$(document).ready(function () {
    function filterDitujukan() {
        const tipeSelect = $('#tipe');
        if (!tipeSelect.length) return; // keluar jika tidak ada #tipe
        
        const tipe = tipeSelect.val();
        $('#ditujukan option').each(function () {
            const id = parseInt($(this).data('id'));
            if (!id) return;

            if (tipe === 'permohonan') {
                if (id >= 1 && id <= 3) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            } else {
                $(this).show();
            }
        });

        const selectedOption = $('#ditujukan option:selected');
        if (selectedOption.is(':hidden')) {
            $('#ditujukan').val('');
        }
    }

    filterDitujukan();

    $('#tipe').on('change', function () {
        filterDitujukan();
    });
});
</script>

@endsection
