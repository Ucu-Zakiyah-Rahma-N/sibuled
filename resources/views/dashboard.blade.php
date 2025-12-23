@extends('app.template')

@section('content')

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'berhasil masuk',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    {{ session()->forget('success') }}
@endif

<style>
.stats-card {
    border-radius: 10px;
    padding: 16px 18px;
    border: 1px solid #e6e6e6;
    background: #fff;
    display: flex;
    align-items: center;
    gap: 12px;
}

.stats-icon {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #fff;
    flex-shrink: 0;
}

.stats-label {
    font-size: 12px;
    color: #666;
    margin-bottom: 3px;
}

.stats-value {
    font-size: 12px;
    font-weight: 600;
    margin: 0;
}

.dashboard-header {
    margin-bottom: 1rem;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

</style>

<div class="card mb-3">
    <div class="card-body">
        <p class="mb-0">
            Selamat Datang <b>{{ $user->username }}</b>
        </p>
    </div>
</div>

@if(in_array(strtolower($user->role), ['superadmin', 'admin marketing', 'ceo',  'direktur', 'manager marketing', 'manager project', 'manager finance']))
<div class="dashboard-header">
    Rekap Bulan Ini
</div>

<div class="row g-3">
    
    {{-- Jumlah PO --}}
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stats-card">
            <div class="stats-icon" style="background:#4a74ff;">
                <i class="ti ti-file-invoice"></i>
            </div>
            <div>
                <div class="stats-label">Jumlah PO</div>
                <div class="stats-value">{{ $jumlahPO ?? 0 }}</div>
            </div>
        </div>
    </div>

    {{-- Nilai PO --}}
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stats-card">
            <div class="stats-icon" style="background:#1abc9c;">
                <i class="ti ti-cash"></i>
            </div>
            <div>
                <div class="stats-label">Nilai PO</div>
                <div class="stats-value">Rp {{ number_format($nilaiPO ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- Achievement --}}
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stats-card">
            <div class="stats-icon" style="background:#f1c40f;">
                <i class="ti ti-chart-pie"></i>
            </div>
            <div>
                <div class="stats-label">Achievement</div>
                <div class="stats-value">{{ $persentaseAchieve ?? 0 }}%</div>
            </div>
        </div>
    </div>

    {{-- Target Bulan Ini --}}
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stats-card">
            <div class="stats-icon" style="background:#e67e22;">
                <i class="ti ti-target"></i>
            </div>
            <div>
                <div class="stats-label">Target Bulan Ini</div>
                <div class="stats-value">Rp {{ number_format($targetBulanIni ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

</div>

<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-white">
        <h6 class="mb-0 fw-semibold">Grafik Nilai PO per Bulan</h6>
    </div>

    <div class="card-body">
        <canvas id="chartNilaiPO" height="90"></canvas>
    </div>
</div>
@endif

@if(in_array(strtolower($user->role), ['admin 1', 'admin 2', 'ceo', 'direktur', 'manager marketing', 'manager projek', 'manager finance']))
        {{-- REKAP PROJECT --}}
        <div class="dashboard-header">
    Rekap Project
</div>

    <div class="card-body">
        <div class="d-flex justify-content-center mb-1"> {{-- jarak lebih kecil ke tabel --}}
            <div class="d-flex flex-wrap justify-content-center gap-2 flex-nowrap" style="max-width: 1000px;">
                
                {{-- Belum Mulai --}}
                <div class="card shadow border-0" style="width: 220px; height: 100px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="ti ti-clock fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted">Belum Mulai</h6>
                            <h4 class="fw-bold mb-0">{{ $rekap['belum_mulai'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>

                {{-- On Progress --}}
                <div class="card shadow border-0" style="width: 220px; height: 100px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="ti ti-loader fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted">On Progress</h6>
                            <h4 class="fw-bold mb-0">{{ $rekap['on_progress'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>

                {{-- Selesai --}}
                <div class="card shadow border-0" style="width: 220px; height: 100px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="ti ti-check fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted">Selesai</h6>
                            <h4 class="fw-bold mb-0">{{ $rekap['selesai'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>

                {{-- Total --}}
                <div class="card shadow border-0" style="width: 220px; height: 100px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="ti ti-list fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted">Total Project</h6>
                            <h4 class="fw-bold mb-0">{{ $rekap['total'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>

@endif

@if(in_array(strtolower($user->role), ['CEO', 'direktur']))

@endif
{{-- ================= SCRIPT UNTUK CHART ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        // Data dari Controller
        const bulan = @json($bulan);                   // ['Jan', 'Feb', ...]
        const nilaiPerBulan = @json($nilaiPerBulan);   // [54000000, 72000000, ...]

        const ctx = document.getElementById('chartNilaiPO').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: bulan,
                datasets: [{
                    label: 'Nilai PO',
                    data: nilaiPerBulan,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.15)',
                    borderWidth: 3,
                    tension: 0.3,
                    pointBackgroundColor: '#0d6efd',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let val = context.raw || 0;
                                return 'Rp ' + val.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value){
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>


@endsection