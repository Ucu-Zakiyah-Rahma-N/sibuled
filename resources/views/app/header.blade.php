<header class="app-header">
<nav class="navbar navbar-expand-lg navbar-light">
    <ul class="navbar-nav">
    <li class="nav-item d-block d-xl-none">
        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
        <i class="ti ti-menu-2"></i>
        </a>
    </li>
    </ul>
    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
        <li class="nav-item">
        {{ auth()->user()->profile->nama }}
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
            aria-expanded="false">
            <img src="{{ asset('assets/images/user.png') }}" alt="" width="35" height="35" class="rounded-circle">
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
            <div class="message-body">
            <div class="text-center">
            <p class="m-0">{{ auth()->user()->profile->nip }}</p>
            <p class="m-0">{{ auth()->user()->profile->golongan }}</p>
            </div>
            <hr class="m-1">
            <a href="{{ url('my_profile') }}" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-user fs-5 text-primary"></i>
                <p class="mb-0 fs-3">My Profile</p>
            </a>
            <hr class="m-0">            
            <a href="#" id="logoutBtn" class="btn btn-outline-primary mx-3 mt-2 d-block">Keluar</a>
            <form id="logoutForm" action="{{ url('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            </div>
        </div>
        </li>
    </ul>
    </div>
</nav>
</header>

<script>
    $(document).ready(function () {
        $('#logoutBtn').on('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Yakin untuk keluar ?',
                text: "Kamu akan keluar dari sesi ini.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#logoutForm').submit();
                }
            });
        });
    });
</script>
