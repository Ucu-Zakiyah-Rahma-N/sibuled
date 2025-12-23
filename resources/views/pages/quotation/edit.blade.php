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

<div class="card">
    <div class="card-header">
       <h5>Edit Projek: {{ $quotation->no_sph ?? '-' }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('quotation.update', $quotation->id) }}" method="POST" id="formProyek">
            @csrf
            @method('PUT')

            {{-- Pilih Customer --}}
            <div class="col md-3 mb-3">
                <label>Nama Perusahaan<span class="text-danger">*</span></label>
                <select id="customer-select" name="customer_id" class="form-select">
                    <option value="">-- Pilih Perusahaan --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $quotation->customer_id == $customer->id ? 'selected' : '' }}>
                            {{ $customer->nama_perusahaan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nomor & Tanggal SPH --}}
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label>Nomor SPH<span class="text-danger">*</span></label>
                    <input type="text" name="no_sph" class="form-control" value="{{ $quotation->no_sph }}">
                </div>
                <div class="col-md-6">
                    <label>Tanggal SPH<span class="text-danger">*</span></label>
                    <input type="date" name="tgl_sph" class="form-control" value="{{ $quotation->tgl_sph }}">
                </div>
            </div>

            {{-- Nama Bangunan --}}
<div class="col-md-6 mb-3">
    <label>Nama Bangunan<span class="text-danger">*</span></label>
    <div class="d-flex align-items-center">
        <input type="text" name="nama_bangunan" class="form-control" value="{{ $quotation->nama_bangunan }}">
        <div class="form-check ms-2">
            <input type="hidden" name="is_same_nama_bangunan" value="0">
            <input class="form-check-input" type="checkbox" id="copyNama" name="is_same_nama_bangunan" value="1"
                {{ $quotation->is_same_nama_bangunan ? 'checked' : '' }}>
            <label class="form-check-label" for="copyNama">Sama</label>
        </div>
    </div>
</div>

            {{-- Alamat --}}
<div class="col-md-6 mb-3">
    <label>Provinsi<span class="text-danger">*</span></label>
    <div class="d-flex align-items-center gap-2">

    <select id="provinsi_id" name="provinsi_id" class="form-select">
        <option value="">-- Pilih Provinsi --</option>
        @foreach($provinsiList as $prov)
            <option value="{{ $prov->kode }}" {{ $quotation->provinsi_id == $prov->kode ? 'selected' : '' }}>
                {{ $prov->nama }}
            </option>
        @endforeach
    </select>

    <div class="form-check mb-0">
        <input type="hidden" name="is_same_alamat" value="0">
        <input class="form-check-input" type="checkbox" id="copyAlamat" name="is_same_alamat" value="1"
            {{ $quotation->is_same_alamat ? 'checked' : '' }}>
        <label class="form-check-label" for="copyAlamat">Sama</label>
    </div>
</div>
</div>
                <div class="row mb-3">
                <div class="col-md-6">
                    <label>Kabupaten / Kota<span class="text-danger">*</span></label>
                    <select id="kabupaten_id" name="kabupaten_id" class="form-select"></select>
                </div>
                <div class="col-md-6">
                    <label>Kawasan<span class="text-danger">*</span></label>
                    <select id="kawasan_id" name="kawasan_id" class="form-select"></select>
                </div>
                <div class="col-md-6">
                <label>Detail Alamat<span class="text-danger">*</span></label>
                <input type="text" name="detail_alamat" class="form-control" value="{{ $quotation->detail_alamat }}">
            </div>
            </div>

            {{-- Lama Pekerjaan --}}
            <div class="mb-3">
                <label>Lama Pekerjaan (hari)<span class="text-danger">*</span></label>
                <input type="number" name="lama_pekerjaan" class="form-control" value="{{ $quotation->lama_pekerjaan }}">
            </div>

            <div class="mb-3">
                <label>Jumlah Termin Pembayaran <span class="text-danger">*</span></label>
                <select name="jumlah_termin" id="jumlah_termin" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="1" {{ count($terminLama) == 1 ? 'selected' : '' }}>1 Termin</option>
                    <option value="2" {{ count($terminLama) == 2 ? 'selected' : '' }}>2 Termin</option>
                    <option value="3" {{ count($terminLama) == 3 ? 'selected' : '' }}>3 Termin</option>
                </select>
            </div>

            <div id="formTermin">
                {{-- Jika sudah ada data (edit), tampilkan otomatis --}}
                @if($terminLama)
                    <div class="row">
                    @foreach($terminLama as $t)
                        <div class="col-md-4 mb-3">
                            <label>Termin {{ $t['urutan'] }} (%)</label>
                            <input type="number"
                                name="termin[{{ $t['urutan'] }}]"
                                class="form-control termin-input"
                                value="{{ $t['persen'] }}"
                                min="1" max="100">
                        </div>
                    @endforeach
                    </div>
                @endif
            </div>

            <div id="validasiTotal" class="mt-2 fw-bold"></div>

            {{-- Pilih Jenis Perizinan --}}
            <div class="mb-3">
                <label>Jenis Perizinan</label>
                <div id="daftar-perizinan" class="row">
                    @foreach($perizinan as $p)
                    <div class="col-md-4 mb-2">
                        <label class="border rounded p-3 d-block">
                            <input type="checkbox" name="perizinan_id[]" value="{{ $p->id }}" class="jenis-checkbox" 
                                {{ $quotationPerizinan->pluck('perizinan_id')->contains($p->id) ? 'checked' : '' }}>
                            {{ $p->jenis }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Tipe Harga --}}
            <div class="mb-3" id="tipeHargaGroup">
                <label>Tipe Harga</label>
                <select name="harga_tipe" id="harga_tipe" class="form-select">
                    <option value="">-- Pilih --</option>
                    <option value="satuan" {{ $quotation->harga_tipe == 'satuan' ? 'selected' : '' }}>Harga Satuan</option>
                    <option value="gabungan" {{ $quotation->harga_tipe == 'gabungan' ? 'selected' : '' }}>Harga Gabungan</option>
                </select>
            </div>

            {{-- Harga Gabungan --}}
            <div class="mb-3" id="hargaGabunganGroup" style="{{ $quotation->harga_tipe=='gabungan'?'display:block':'display:none' }}">
                <label>Harga Gabungan (Rp)</label>
                <input type="text" name="harga_gabungan" id="harga_gabungan" class="form-control format-angka" 
                    value="{{ old('harga_gabungan', $quotation->harga_gabungan) }}">
            </div>

            {{-- Form harga perizinan --}}
            <div id="formHargaPerizinan">
            @foreach($quotationPerizinan as $qp)
                @php
                    $jenisUpper = strtoupper($qp->perizinan->jenis);
                    $luasField = null;
                    if(str_contains($jenisUpper, 'SLF')) $luasField = 'luas_slf';
                    elseif(str_contains($jenisUpper, 'PBG')) $luasField = 'luas_pbg';
                    elseif(str_contains($jenisUpper, 'SHGB')) $luasField = 'luas_shgb';
                @endphp

                <div class="card mb-3" id="harga-{{ $qp->perizinan_id }}">
                    <div class="card-body">
                        <h6 class="fw-bold">{{ $qp->perizinan->jenis }}</h6>

                <div class="mb-2">
                    <label>Harga (Rp)</label>
                    <input 
                        type="text" 
                        name="harga_satuan[{{ $qp->perizinan_id }}]" 
                        class="form-control format-angka"
                        value="{{ number_format(old('harga_satuan.'.$qp->perizinan_id, $qp->harga_satuan), 0, ',', '.') }}">
                </div>

                        @if($luasField)
                        <div class="mb-2">
                            <label>Luas {{ $qp->perizinan->jenis }} (m²)</label>
                            <input type="number" step="any" name="{{ $luasField }}[{{ $qp->perizinan_id }}]" class="form-control"
                                value="{{ old($luasField.'.'.$qp->perizinan_id, $quotation->$luasField) }}">
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
            </div>

            <button type="submit" class="btn btn-success mt-3">Update</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){

// untuk ribuan
function formatRibuan(angka) {
    if(!angka && angka !== 0) return "";

    // ubah ke integer dulu, buang desimal
    let intAngka = Math.floor(Number(angka));

    // format ribuan
    return intAngka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$(".format-angka").each(function(){
    let val = $(this).val();
    if(val) $(this).val(formatRibuan(val));
});
// saat mengetik
$(document).on("input", ".format-angka", function () {
    let value = $(this).val().replace(/\./g, ""); // hapus titik ribuan
    if(value === "") { $(this).val(""); return; }
    $(this).val(formatRibuan(value));
});

// sebelum submit ke DB
$("form").on("submit", function () {
    $(".format-angka").each(function () {
        this.value = this.value.replace(/\./g, ""); // hapus titik ribuan
    });
});

    // Load kabupaten otomatis
    let selectedProv = '{{ $quotation->provinsi_id }}';
    let selectedKab = '{{ $quotation->kabupaten_id }}';
    let selectedKaw = '{{ $quotation->kawasan_id }}';
    let selectedAlamat = '{{ $quotation->detail_alamat }}';

if(selectedProv) {
    $.get(`/wilayah/kabupaten/${selectedProv}`, function(kab){
        $('#kabupaten_id').html('<option value="">-- Pilih Kabupaten/Kota --</option>');
        kab.forEach(k=>{
            $('#kabupaten_id').append(`<option value="${k.kode}" ${k.kode==selectedKab?'selected':''}>${k.nama}</option>`);
        });

        // Load kawasan setelah kabupaten tersedia
        if(selectedKab) {
            $.get(`/kawasan/${selectedKab}`, function(kaw){
            console.log(kaw); // lihat apakah data kembali
            $('#kawasan_id').html('<option value="">-- Pilih Kawasan --</option>');
            kaw.forEach(k=>{
                $('#kawasan_id').append(`<option value="${k.id}" ${k.id==selectedKaw?'selected':''}>${k.nama_kawasan}</option>`);
            });
        });

        }
    });
}
function loadKabupaten(provId) {
    return $.get(`/wilayah/kabupaten/${provId}`, function(kab){
        $('#kabupaten_id').html('<option value="">-- Pilih Kabupaten/Kota --</option>');
        kab.forEach(k=>{
            $('#kabupaten_id').append(`<option value="${k.kode}">${k.nama}</option>`);
        });
    });
}

function loadKawasan(kabId) {
    return $.get(`/kawasan/${kabId}`, function(kaw){
        $('#kawasan_id').html('<option value="">-- Pilih Kawasan --</option>');
        kaw.forEach(k=>{
            $('#kawasan_id').append(`<option value="${k.id}">${k.nama_kawasan}</option>`);
        });
    });
}


$('#copyAlamat').change(function(){
    const checked = $(this).is(':checked');

if(checked){
        // Prefill otomatis
        $('#provinsi_id').val(selectedProv);

        // Load kabupaten dulu
        loadKabupaten(selectedProv).then(()=>{
            $('#kabupaten_id').val(selectedKab);

            // Load kawasan
            loadKawasan(selectedKab).then(()=>{
                $('#kawasan_id').val(selectedKaw);

                // Baru set detail alamat
                $('input[name="detail_alamat"]').val(selectedAlamat);
            });
        });
    }  else {
        // Reset semua untuk input manual
        $('#provinsi_id').val('');
        $('#kabupaten_id').html('<option value="">-- Pilih Kabupaten/Kota --</option>');
        $('#kawasan_id').html('<option value="">-- Pilih Kawasan --</option>');
        $('input[name= "detail_alamat"]').val('');
    }
});

// Event manual dropdown
$('#provinsi_id').change(function(){
    let provId = $(this).val();
    $('#provinsi_id_hidden').val(provId);
    loadKabupaten(provId);
});

$('#kabupaten_id').change(function(){
    let kabId = $(this).val();
    $('#kabupaten_id_hidden').val(kabId);
    loadKawasan(kabId);
});


//harga
function buatCardPerizinan(id, label) {
    const luasMap = { 'SLF': 'luas_slf', 'PBG': 'luas_pbg', 'SHGB': 'luas_shgb' };
    const perizinanButuhLuas = ['SLF','PBG','SHGB'];
    const labelUpper = label.toUpperCase();
    let luasFieldName = null;
    const found = perizinanButuhLuas.find(nama => labelUpper.includes(nama));
    if(found) luasFieldName = luasMap[found];

    let luasHtml = '';
    if(luasFieldName){
        luasHtml = `
        <div class="mb-2">
            <label>Luas ${label} (m²) - isi dengan titik</label>
            <input type="number" name="${luasFieldName}[${id}]" class="form-control" step="any">
        </div>`;
    }

    return `
    <div class="card mb-3" id="harga-${id}">
        <div class="card-body">
            <h6 class="fw-bold">${label}</h6>
            <div class="mb-2">
                <label>Harga (Rp)</label>
                <input type="text" name="harga_satuan[${id}]" class="form-control format-angka">
            </div>
            ${luasHtml}
        </div>
    </div>`;
}


//Event listener checkbox perizinan
const checkboxes = document.querySelectorAll('input[name="perizinan_id[]"]');
const tipeHargaGroup = document.getElementById('tipeHargaGroup');
const hargaGabunganGroup = document.getElementById('hargaGabunganGroup');
const formHargaPerizinan = document.getElementById('formHargaPerizinan');
const hargaTipe = document.getElementById('harga_tipe');
const inputGabungan = document.querySelector('input[name="harga_gabungan"]');

// 🔹 fungsi hitung total harga satuan
function hitungTotalHargaSatuan() {
    let total = 0;
    checkboxes.forEach(cb => {
        if (cb.checked) {
            const hargaInput = document.querySelector(`input[name="harga_satuan[${cb.value}]"]`);
            if (hargaInput && hargaInput.value) {
                total += parseFloat(hargaInput.value) || 0;
            }
        }
    });
    return total;
}

checkboxes.forEach(cb => {
    cb.addEventListener('change', function(){
        const id = this.value;
        const label = this.parentElement.textContent.trim();
        const card = document.getElementById(`harga-${id}`);
        const tipeSekarang = hargaTipe.value; // ⬅️ cek tipe harga aktif

        // Tampilkan tipe harga jika ada minimal 1 checkbox dipilih
        const adaYangDipilih = Array.from(checkboxes).some(c => c.checked);
        tipeHargaGroup.style.display = adaYangDipilih ? 'block' : 'none';

        if(this.checked){
            if(!card){
                const cardHtml = buatCardPerizinan(id,label);
                formHargaPerizinan.insertAdjacentHTML('beforeend', cardHtml);
            }

            const cardEl = document.getElementById(`harga-${id}`);
            cardEl.classList.remove('d-none');

            // Kalau sedang dalam mode gabungan → sembunyikan input harga satuan
            if(tipeSekarang === 'gabungan'){
                const hargaInput = cardEl.querySelector('input[name^="harga_satuan"]');
                if(hargaInput) hargaInput.closest('.mb-2').style.display = 'none';
            }

        } else {
            if(card) card.classList.add('d-none');
        }
    });
});

// 🔹 Event tipe harga
hargaTipe.addEventListener('change', function(){
    const tipe = this.value;

    if(tipe === 'gabungan'){
        hargaGabunganGroup.style.display = 'block';
        formHargaPerizinan.style.display = 'block';

        // tampilkan semua card tapi sembunyikan input harga satuan
        const cards = formHargaPerizinan.querySelectorAll('.card');
        cards.forEach(card => {
            card.classList.remove('d-none');
            const hargaInput = card.querySelector('input[name^="harga_satuan"]');
            if(hargaInput) hargaInput.closest('.mb-2').style.display = 'none';
        });

        // 💥 Hitung total harga satuan dan tampilkan di harga gabungan
        const total = hitungTotalHargaSatuan();
        inputGabungan.value = total > 0 ? total : '';

    } else if(tipe === 'satuan'){
        hargaGabunganGroup.style.display = 'none';
        formHargaPerizinan.style.display = 'block';
        checkboxes.forEach(cb => {
            const card = document.getElementById(`harga-${cb.value}`);
            if(card){
                if(cb.checked){
                    card.classList.remove('d-none');
                    const hargaInput = card.querySelector('input[name^="harga_satuan"]');
                    if(hargaInput) hargaInput.closest('.mb-2').style.display = 'block';
                } else {
                    card.classList.add('d-none');
                }
            }
        });
    } else {
        hargaGabunganGroup.style.display = 'none';
        formHargaPerizinan.style.display = 'none';
    }
});


// 🔹 Pre-fill card harga lama (edit)
const qpData = @json($quotationPerizinan->keyBy('perizinan_id'));
const quotationData = @json([
    'luas_slf' => $quotation->luas_slf,
    'luas_pbg' => $quotation->luas_pbg,
    'luas_shgb' => $quotation->luas_shgb
]);

checkboxes.forEach(cb => {
    const id = parseInt(cb.value);
    const label = cb.parentElement.textContent.trim();

    if(qpData[id]){
        cb.checked = true;

        // buat card jika belum ada
        if(!document.getElementById(`harga-${id}`)){
            const cardHtml = buatCardPerizinan(id,label);
            formHargaPerizinan.insertAdjacentHTML('beforeend', cardHtml);
        }

        const cardEl = document.getElementById(`harga-${id}`);
        if(cardEl){
            // set harga
            const hargaInput = cardEl.querySelector(`input[name="harga_satuan[${id}]"]`);
            if(hargaInput) hargaInput.value = formatRibuan(qpData[id].harga_satuan);

            // set luas sesuai jenis
            let jenisUpper = label.toUpperCase();
            let luasField = null;
            if(jenisUpper.includes('SLF')) luasField = 'luas_slf';
            else if(jenisUpper.includes('PBG')) luasField = 'luas_pbg';
            else if(jenisUpper.includes('SHGB')) luasField = 'luas_shgb';

            if(luasField){
                const luasInput = cardEl.querySelector(`input[name="${luasField}[${id}]"]`);
                if(luasInput) luasInput.value = quotationData[luasField] ?? '';
            }
        }
    }
});

// ----------------------------
// Set tampilan tipe harga sesuai data quotation
// ----------------------------
const tipe = '{{ $quotation->harga_tipe ?? "satuan" }}';
hargaTipe.value = tipe;

if(tipe === 'gabungan'){
    hargaGabunganGroup.style.display = 'block';
    formHargaPerizinan.style.display = 'block';

    // sembunyikan input harga tapi tampilkan luas
    const cards = formHargaPerizinan.querySelectorAll('.card');
    cards.forEach(card => {
        card.classList.remove('d-none');
        const hargaInput = card.querySelector('input[name^="harga_satuan"]');
        if(hargaInput) hargaInput.closest('.mb-2').style.display = 'none';
    });

        if(inputGabungan){
            let val = parseFloat('{{ $quotation->harga_gabungan ?? 0 }}') || 0;
            inputGabungan.value = formatRibuan(val);
        }

} else {
    hargaGabunganGroup.style.display = 'none';
    formHargaPerizinan.style.display = 'block';
}

//edit untuk termin
$('#jumlah_termin').on('change', function() {
    const jumlah = parseInt($(this).val());
    const formTermin = $('#formTermin');

    formTermin.html('');

    if (!jumlah) return;

    let html = '<div class="row">';

    for (let i = 1; i <= jumlah; i++) {
        html += `
            <div class="col-md-4 mb-3">
                <label>Termin ${i} (%)</label>
                <input type="number"
                       name="termin[${i}]"
                       class="form-control termin-input"
                       min="1" max="100"
                       placeholder="Masukkan persentase...">
            </div>
        `;
    }

    html += '</div>';
    formTermin.html(html);
});

// VALIDASI TOTAL
$(document).on('input', '.termin-input', function() {
    let total = 0;
    $('.termin-input').each(function() {
        total += Number($(this).val()) || 0;
    });

    if (total === 100) {
        $('#validasiTotal').html(`<span class="text-success">Total persentase: 100% ✔</span>`);
    } else {
        $('#validasiTotal').html(`<span class="text-danger">Total persentase: ${total}% (harus 100%)</span>`);
    }
});

});
</script>
@endsection
