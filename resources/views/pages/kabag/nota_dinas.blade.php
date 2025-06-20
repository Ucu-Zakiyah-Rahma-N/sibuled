@extends('app.template')

@section('content')

  <a class="btn btn-danger mb-3" href="{{ url('surat_masuk') }}">Kembali</a>

<div class="card">
    <div class="card-body">
        <form action="{{ url('kabag/nota_dinas/upload') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="text" name="kartu_disposisi_id" value="{{ $ks->id }}" hidden>

            {{-- file nota dinas --}}
            <div class="mb-3">
                <label for="file_nota_dinas" class="form-label">Unggah Nota Dinas <span class="text-danger">*</span></label>
                <input type="file" class="form-control @error('file_nota_dinas') is-invalid @enderror" id="file_nota_dinas" name="file_nota_dinas" value="{{ old('file_nota_dinas') }}">
                @error('file_nota_dinas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            

            <button type="submit" class="btn btn-success">Unggah</button>
        </form>
    </div>
</div>

@endsection
