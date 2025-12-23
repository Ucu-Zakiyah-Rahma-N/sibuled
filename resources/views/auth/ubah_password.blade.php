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

<a class="btn btn-danger mb-3" href="{{ url('users') }}">Kembali</a>

<div class="card">
    <div class="card-body">
        <form action="{{ url('update_password/' . $user->id) }}" method="POST">
            @csrf
            @method('PATCH')

            {{-- Password Baru --}}
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password">
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                        <i class="bi bi-eye-slash"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" 
                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                           id="password_confirmation" 
                           name="password_confirmation">
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword2">
                        <i class="bi bi-eye-slash"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Ubah Password</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Password utama
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const icon = this.querySelector('i');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            passwordField.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    });

    // Password konfirmasi
    document.getElementById('togglePassword2').addEventListener('click', function () {
        const passwordField = document.getElementById('password_confirmation');
        const icon = this.querySelector('i');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            passwordField.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    });
</script>
@endpush
