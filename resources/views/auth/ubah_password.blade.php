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
        <form action="{{ url('kabag/update_password/' . $user->id) }}" method="POST">
            @csrf
            @method('PATCH')

            {{-- Password Baru --}}
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Ubah Password</button>
        </form>
    </div>
</div>
@endsection
