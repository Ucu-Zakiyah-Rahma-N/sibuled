@extends('app.template')

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ url('kabag/kartu_disposisi') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="text" name="surat_id" value="{{ $surat->id }}" hidden>

            {{-- index --}}
            <div class="mb-3">
                <label for="index" class="form-label">Index <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('index') is-invalid @enderror" id="index" name="index" value="{{ old('index') }}">
                @error('index')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- tgl_penyelesaian --}}
            <div class="mb-3">
                <label for="tgl_penyelesaian" class="form-label">Tanggal Penyelesaian <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tgl_penyelesaian') is-invalid @enderror" id="tgl_penyelesaian" name="tgl_penyelesaian" value="{{ old('tgl_penyelesaian') }}">
                @error('tgl_penyelesaian')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- diteruskan --}}
            <div class="mb-3">
                <label for="diteruskan" class="form-label">Diteruskan Ke <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('diteruskan') is-invalid @enderror" id="diteruskan" name="diteruskan" value="{{ old('diteruskan') }}">
                @error('diteruskan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- keputusan --}}
            <div class="mb-3">
                <label for="keputusan" class="form-label">Keputusan <span class="text-danger">*</span></label>
                <select class="form-select @error('keputusan') is-invalid @enderror" name="keputusan">
                    <option value="" disabled {{ old('keputusan') ? '' : 'selected' }}>-- pilih keputusan --</option>
                    <option value="intruksi" {{ old('keputusan') == 'intruksi' ? 'selected' : '' }}>Intruksi</option>
                    <option value="informasi" {{ old('keputusan') == 'informasi' ? 'selected' : '' }}>Informasi</option>
                </select>
                @error('keputusan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> 
            
            {{-- Catatan --}}
            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan <span class="text-danger">*</span></label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Buat Kartu Disposisi</button>
        </form>
    </div>
</div>

@endsection
