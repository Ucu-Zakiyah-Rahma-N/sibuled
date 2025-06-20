@extends('app.template')

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ url('asda/disposisi/store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="text" name="surat_id" value="{{ $surat->id }}" hidden>

            {{-- nomor_agenda --}}
            <div class="mb-3">
                <label for="nomor_agenda" class="form-label">Nomor agenda <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nomor_agenda') is-invalid @enderror" id="nomor_agenda" name="nomor_agenda" value="{{ old('nomor_agenda') }}">
                @error('nomor_agenda')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Sifat --}}
            <div class="mb-3">
                <label for="sifat" class="form-label">Sifat <span class="text-danger">*</span></label>
                <select class="form-select @error('sifat') is-invalid @enderror" name="sifat">
                    <option value="" disabled {{ old('sifat') ? '' : 'selected' }}>-- pilih sifat --</option>
                    <option value="Sangat Segera" {{ old('sifat') == 'Sangat Segera' ? 'selected' : '' }}>Sangat Segera</option>
                    <option value="Segera" {{ old('sifat') == 'Segera' ? 'selected' : '' }}>Segera</option>
                    <option value="Rahasia" {{ old('sifat') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                </select>
                @error('sifat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>            

            {{-- Penerima --}}
            <div class="mb-3">
                <label for="ditujukan" class="form-label">ditujukan <span class="text-danger">*</span></label>
                <select class="form-select @error('ditujukan') is-invalid @enderror" name="ditujukan">
                    <option value="" disabled {{ old('ditujukan') ? '' : 'selected' }}>-- pilih penerima --</option>
                    <option value="1" {{ old('ditujukan') == '1' ? 'selected' : '' }}>Kepala bagian Ekonomi</option>
                </select>
                @error('ditujukan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Penerima --}}
            <div class="mb-3">
                <label for="intruksi" class="form-label">intruksi <span class="text-danger">*</span></label>
                <select class="form-select @error('intruksi') is-invalid @enderror" name="intruksi">
                    <option value="" disabled {{ old('intruksi') ? '' : 'selected' }}>-- pilih intruksi --</option>
                    <option value="Tanggapan dan saran" {{ old('intruksi') == 'Tanggapan dan saran' ? 'selected' : '' }}>Tanggapan dan saran</option>
                    <option value="Proses lebih lanjut" {{ old('intruksi') == 'Proses lebih lanjut' ? 'selected' : '' }}>Proses lebih lanjut</option>
                    <option value="Koordinasi/Konfirmasikan" {{ old('intruksi') == 'Koordinasi/Konfirmasikan' ? 'selected' : '' }}>Koordinasi/Konfirmasikan</option>
                </select>
                @error('intruksi')
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

            <button type="submit" class="btn btn-success">Disposisikan</button>
        </form>
    </div>
</div>

@endsection
