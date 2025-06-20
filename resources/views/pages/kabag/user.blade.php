@extends('app.template')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center mb-0">
            <h5 class="card-title mb-0">Data User</h5>
            <a href="{{ url('kabag/user/create') }}" class="btn btn-primary">Tambah User</a>
        </div>
    </div>
    <div class="card-body">
        <div class="responsive">
            <table class="table">
                <thead>
                    <th>No</th>
                    <th>username</th>
                    <th>Email</th>
                    <th>Bagian</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @php
                        $nomor = 1;
                    @endphp
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $nomor++ }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->bagian->nama_bagian }}</td>
                            <td>
                            <div class="dropdown">
                            <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Opsi
                            </a>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ url('kabag/user/detail/' . $user->id) }}">Lihat Detail</a></li>
                                <li><a class="dropdown-item" href="{{ url('kabag/ubah_password/' . $user->id) }}">Ubah Password</a></li>
                                <li>
                                    <a href="javascript:void(0);" 
                                    class="dropdown-item btn-delete-user" 
                                    data-id="{{ $user->id }}" 
                                    data-nama="{{ $user->username }}">
                                    Hapus User
                                    </a>
                                </li>
                            </ul> 
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.btn-delete-user').click(function () {
            const userId = $(this).data('id');
            const userName = $(this).data('nama');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "User: " + userName,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim request DELETE ke server
                    $.ajax({
                        url: '/kabag/user/' + userId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire(
                                'Berhasil!',
                                'User berhasil dihapus.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus user.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>

@endsection