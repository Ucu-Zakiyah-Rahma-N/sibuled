<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="text-nowrap logo-img">
            <img src="{{ asset('assets/images/karawang.svg') }}" width="180" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ url('dashboard') }}" aria-expanded="false">
                <span>
                    <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
                </a>
            </li>
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Surat</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ url('surat_masuk') }}" aria-expanded="false">
                <span>
                    <i class="ti ti-message"></i>
                </span>
                <span class="hide-menu d-inline-flex align-items-center">
                    Surat Masuk
                    @php
                        $surat = $smbd + $jds + $jda + $jkd;
                    @endphp
                    @if ($surat > 0)
                    <span class="badge bg-warning text-white ms-2">{{ $surat }}</span>
                    @endif
                </span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ url('surat_keluar') }}" aria-expanded="false">
                <span>
                    <i class="ti ti-location"></i>
                </span>
                <span class="hide-menu">Surat Keluar</span>
                </a>
            </li>
            @if (auth()->user()->bagian->id === 1)
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Menu Kabag</span>
            </li>
               <li class="sidebar-item">
                <a class="sidebar-link" href="{{ url('kabag/users') }}" aria-expanded="false">
                <span>
                    <i class="ti ti-user"></i>
                </span>
                <span class="hide-menu">Users</span>
                </a>
            </li>                
            @elseif (auth()->user()->bagian->id === 2)
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Menu Sekda</span>
            </li>    
            @elseif (auth()->user()->bagian->id === 3)
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Menu Asda</span>
            </li>
            @endif

            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Lainnya</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link contact-admin-link" href="javascript:void(0)" aria-expanded="false">
                    <span>
                        <i class="ti ti-alert-circle"></i>
                    </span>
                    <span class="hide-menu">Bantuan</span>
                </a>
            </li>
            </ul>
        </nav>
    </div>
</aside>

<script>
    $(document).ready(function() {
        $('.contact-admin-link').on('click', function(e) {
            e.preventDefault(); // Prevent default link behavior (e.g., navigating to #)

            Swal.fire({
                title: 'Bantuan',
                text: 'Silakan hubungi admin untuk bantuan lebih lanjut.',
                icon: 'info', // You can change this to 'success', 'warning', 'error', 'question'
                confirmButtonText: 'Oke'
            });
        });
    });
</script>