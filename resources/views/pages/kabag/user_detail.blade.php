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
@endif

<a class="btn btn-danger mb-3" href="{{ url('kabag/users') }}">Kembali</a>

<div class="card">
    <div class="card-body">
        <form action="{{ url('kabag/user/' . $user->id) }}" method="POST">
            @method('put')
            @csrf
            {{-- Username --}}
            <div class="mb-3">
                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control @error('username') is-invalid @enderror" 
                       id="username" 
                       name="username" 
                       value="{{ old('username', $user->username ?? '') }}">
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $user->email ?? '') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Bagian --}}
            <div class="mb-3">
                <label for="bagian_id" class="form-label">Bagian <span class="text-danger">*</span></label>
                <select class="form-select @error('bagian_id') is-invalid @enderror" 
                        name="bagian_id" 
                        id="bagian_id">
                    <option value="" disabled {{ old('bagian_id', $user->bagian_id ?? '') == '' ? 'selected' : '' }}>
                        -- pilih bagian user --
                    </option>
                    @foreach ($bagian as $value)
                        <option value="{{ $value->id }}" 
                                {{ old('bagian_id', $user->bagian_id ?? '') == $value->id ? 'selected' : '' }}>
                            {{ $value->nama_bagian }}
                        </option>
                    @endforeach
                </select>
                @error('bagian_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </form>
    </div>
</div>

@endsection
