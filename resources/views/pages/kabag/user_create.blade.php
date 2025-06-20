@extends('app.template')

@section('content')

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'berhasil',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    {{ session()->forget('success') }}
@endif

<a class="btn btn-danger mb-3" href="{{ url('kabag/users') }}">Kembali</a>

<div class="card">
    <div class="card-body">
        <form action="{{ url('kabag/user') }}" method="POST">
            @csrf

            {{-- username --}}
            <div class="mb-3">
                <label for="username" class="form-label">username <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}">
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- password --}}
            <div class="mb-3">
                <label for="password" class="form-label">password <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- email --}}
            <div class="mb-3">
                <label for="email" class="form-label">email <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Ditujukan --}}
            <div class="mb-3">
                <label for="bagian_id" class="form-label">bagian <span class="text-danger">*</span></label>
                <select class="form-select @error('bagian_id') is-invalid @enderror" name="bagian_id" id="bagian_id">
                    <option value="" disabled {{ old('bagian_id') ? '' : 'selected' }}>-- pilih bagian user --</option>
                    @foreach ($bagian as $value)
                        <option 
                            value="{{ $value->id }}" 
                            data-id="{{ $value->id }}" 
                            {{ old('bagian_id') == $value->id ? 'selected' : '' }}>
                            {{ $value->nama_bagian }}
                        </option>
                    @endforeach
                </select>
                @error('bagian_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Tambahkan User</button>
        </form>
    </div>
</div>

@endsection
