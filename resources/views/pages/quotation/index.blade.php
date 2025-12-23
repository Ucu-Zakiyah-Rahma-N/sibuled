@extends('app.template')

@section('content')
    <style>
        /* Biar Select2 mirip Bootstrap form-select */
        .select2-container--bootstrap5 .select2-selection {
            height: calc(2.25rem + 2px) !important;
            padding: 0.375rem 0.75rem !important;
            font-size: 0.2rem;
            line-height: 1.5;
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
        }

        .select2-container--bootstrap5 .select2-selection__arrow {
            height: 100% !important;
            right: 0.75rem !important;
        }

        .select2-container--bootstrap5 .select2-selection__rendered {
            line-height: 1.5 !important;
            padding-left: 0 !important;
        }

        .select2-container--bootstrap5 {
            width: 100% !important;
        }

        .select2-container .select2-results__option {
            font-size: 0.8rem !important;
            /* atur ukuran font list */


        }
    </style>
    <div class="card">
        <div class="card-header">
            {{-- 🔹 Header --}}
            <div class="d-flex justify-content-between align-items-center mb-0">
                <h5 class="card-title mb-0">Data SPH</h5>
                @if (in_array(auth()->user()->role, ['superadmin', 'admin marketing']))
                    <a href="{{ route('quotation.create') }}" class="btn btn-primary fw-semibold rounded-pill px-3"
                        style="background-color:#4f7cff; border: none;">
                        <i class="bi bi-plus-circle me-1"></i> Tambah SPH
                    </a>
                @endif
            </div>
        </div>

        {{-- 🔹 Card Body --}}
        <div class="card-body">

            {{-- 🔹 Filter Section --}}
            <div class="row align-items-end mb-3 g-2">
                <div class="col-md-2">
                    <label for="filterKabupaten" class="form-label fw-semibold">Kabupaten</label>
                    <select id="filterKabupaten" class="form-select">
                        <option value="">Semua Kabupaten</option>
                        @foreach ($wilayahs->where('jenis', 'kabupaten') as $kab)
                            <option value="{{ $kab->kode }}" {{ request('kabupaten') == $kab->kode ? 'selected' : '' }}>
                                {{ $kab->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="filterKawasan" class="form-label fw-semibold">Kawasan</label>
                    <select id="filterKawasan" class="form-select">
                        <option value="">Semua Kawasan</option>
                        @foreach ($quotation->pluck('kawasan_name')->unique()->filter() as $kawasan)
                            <option value="{{ $kawasan }}" {{ request('kawasan') == $kawasan ? 'selected' : '' }}>
                                {{ $kawasan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5">
                    <div class="row g-2">

                        <!-- Perizinan 1 -->
                        <div class="col-md-6">
                            <label for="filterPerizinan" class="form-label fw-semibold">
                                Jenis Perizinan
                            </label>
                            <select id="filterPerizinan" class="form-select">
                                <option value="">Semua Jenis Perizinan</option>
                                @foreach ($perizinan as $izin)
                                    <option value="{{ $izin->jenis }}"
                                        {{ request('perizinan') == $izin->jenis ? 'selected' : '' }}>
                                        {{ $izin->jenis }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Perizinan 2 -->
                        <div class="col-md-6">
                            <label for="filterCabang" class="form-label fw-semibold">
                                Pilih Cabang
                            </label>
                            <select id="filterCabang" class="form-select">
                                <option value="">Semua Cabang</option>
                                @foreach ($cabang as $c)
                                    <option value="{{ $c->id }}"
                                        {{ request('cabang') == $c->id ? 'selected' : '' }}>
                                        {{ $c->nama_cabang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                <div class="col-md-3">
                    <label for="searchSPH" class="form-label fw-semibold">Cari No SPH</label>
                    <div class="d-flex">
                        <input type="text" id="searchSPH" value="{{ request('search') }}" class="form-control me-2"
                            placeholder="Masukkan No SPH...">
                        <button id="resetFilter" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                @php
                    $no = ($quotation->currentPage() - 1) * $quotation->perPage() + 1;

                @endphp

                <table id="quotationTable" class="table table-bordered align-middle">
                    <thead class="table-light text-center align-middle">
                        <tr>
                            <th>No</th>
                            <th>No SPH</th>
                            {{-- <th>Versi</th> --}}
                            <th>Tanggal SPH</th>
                            <th>Fungsi Bangunan</th>
                            <th>Nama Perusahaan</th>
                            <th>Jenis Perizinan</th>
                            <th>Luas</th>
                            <th>Kabupaten</th>
                            <th>Kawasan</th>
                            <th>Alamat</th>
                            <th>Nominal Pekerjaan</th>
                            <th>Lama Pekerjaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($quotation as $q)
                            <tr data-cabang-id="{{ $q->cabang_id }}">
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $q->no_sph ?? '-' }}</td>
                                <td>{{ $q->tgl_sph ? \Carbon\Carbon::parse($q->tgl_sph)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $q->fungsi_bangunan }}</td>
                                <td>{{ $q->customer->nama_perusahaan ?? '-' }}</td>
                                <td>
                                    @if ($q->perizinan && count($q->perizinan) > 0)
                                        @foreach ($q->perizinan as $izin)
                                            <span
                                                class="badge bg-primary-subtle text-dark border">{{ $izin->jenis }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $q->luas_info ?? '-' }}</td>
                                <td>{{ $q->kabupaten_name ?? '-' }}</td>
                                <td>{{ $q->kawasan_name ?? '-' }}</td>
                                <td>{{ $q->detail_alamat ?? '-' }}</td>
                                {{-- Harga Pekerjaan --}}
                                <td>
                                    @if ($q->harga_tipe == 'gabungan')
                                        Rp {{ number_format($q->harga_gabungan ?? 0, 0, ',', '.') }}
                                    @else
                                        @php
                                            $total = $q->perizinan->sum('pivot.harga_satuan');
                                        @endphp
                                        {{ $total > 0 ? 'Rp ' . number_format($total, 0, ',', '.') : '-' }}
                                    @endif
                                </td>
                                <td>{{ $q->lama_pekerjaan ? "{$q->lama_pekerjaan} hari" : '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('quotation.show', $q->id) }}" class="btn btn-sm btn-outline-info"
                                            title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if (in_array(auth()->user()->role, ['superadmin', 'admin marketing']))
                                            <a href="{{ route('quotation.edit', $q->id) }}"
                                                class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('quotation.download', $q->id) }}"
                                                class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-file-earmark-word"></i>
                                            </a>

                                            <form action="{{ route('quotation.destroy', $q->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus quotation ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="text-center text-muted py-4">
                                    <i class="bi bi-search me-1"></i>
                                    <strong>Data tidak ditemukan</strong>
                                    <div class="small mt-1">
                                        Silakan ubah atau reset filter
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $quotation->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- Script Filter --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const params = new URLSearchParams(window.location.search);

            function reloadWith(key, value) {
                if (value) {
                    params.set(key, value);
                } else {
                    params.delete(key);
                }
                params.delete('page'); // reset page saat filter
                window.location.search = params.toString();
            }



            $('#filterKabupaten, #filterKawasan').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih atau ketik untuk mencari...',
                allowClear: true,
                width: '100%'
            });

            // 🔹 EVENT CHANGE TETAP JALAN
            $('#filterKabupaten').on('change', function() {
                reloadWith('kabupaten', $(this).val());
            });

            $('#filterKawasan').on('change', function() {
                reloadWith('kawasan', $(this).val());
            });


            // // KABUPATEN → langsung reload
            // document.getElementById('filterKabupaten').addEventListener('change', function() {
            //     reloadWith('kabupaten', this.value);
            // });

            // // KAWASAN
            // document.getElementById('filterKawasan').addEventListener('change', function() {
            //     reloadWith('kawasan', this.value);
            // });

            // PERIZINAN
            document.getElementById('filterPerizinan').addEventListener('change', function() {
                reloadWith('perizinan', this.value);
            });

            // CABANG
            document.getElementById('filterCabang').addEventListener('change', function() {
                reloadWith('cabang', this.value);
            });

            // LIVE SEARCH NO SPH
            let typingTimer;
            const delay = 600;
            document.getElementById('searchSPH').addEventListener('input', function() {
                clearTimeout(typingTimer);
                const value = this.value;

                typingTimer = setTimeout(() => {
                    reloadWith('search', value);
                }, delay);
            });

            // RESET
            document.getElementById('resetFilter').addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = window.location.pathname;
            });

        });
    </script>
@endsection
