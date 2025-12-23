@extends('app.template')

@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0">Form Tahapan Dokumen</h5>
  </div>

  <div class="card-body">
  <form action="{{ route('projects.store') }}" method="POST">
      @csrf
        <input type="hidden" name="po_id" value="{{ $po_id }}">

      {{-- Pilih PIC --}}
      <div class="mb-3">
        <label for="marketing_id" >PIC Projek</label>
        <select name="marketing_id" id="marketing_id" class="form-select" required>
          <option value="">-- Pilih PIC --</option>
          @foreach($marketingInternal as $m)
            <option value="{{ $m->id }}">{{ $m->nama }}</option>
          @endforeach
        </select>
      </div>

      <hr>

      {{-- COLLAPSIBLE: COLLECT DOKUMEN --}}
      <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center" 
             data-bs-toggle="collapse" data-bs-target="#collectCollapse" style="cursor:pointer;">
          <h6 class="fw-bold mb-0 text-primary">Pilih Jenis Collect Dokumen</h6>
          <i class="bi bi-chevron-down"></i>
        </div>

        <div id="collectCollapse" class="collapse show">
          <div class="card-body">
            <p class="text-muted small">Klik sesuai urutan pengerjaan. Nomor urutan akan muncul otomatis di kanan.</p>
            <div class="row">
              @foreach ($perizinan as $item)
                <div class="col-md-4 mb-2">
                  <div class="form-check d-flex align-items-center justify-content-between border rounded p-2">
                    <div>
                      <input type="checkbox" class="form-check-input me-2 collect-checkbox" id="collect_{{ $item->id }}" name="perizinan[]" value="{{ $item->id }}">
                      <label class="form-check-label" for="collect_{{ $item->id }}">{{ $item->jenis }}</label>
                    </div>
                    <span class="badge bg-secondary order-badge d-none">0</span>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      {{-- COLLAPSIBLE: TAHAPAN OPSIONAL --}}
      <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center" 
             data-bs-toggle="collapse" data-bs-target="#opsionalCollapse" style="cursor:pointer;">
          <h6 class="fw-bold mb-0 text-primary">Tahapan Lanjutan (Opsional)</h6>
          <i class="bi bi-chevron-down"></i>
        </div>

        <div id="opsionalCollapse" class="collapse show">
          <div class="card-body">
            <p class="text-muted small">Pilih tahapan yang berlaku dan tentukan rencana serta persentasenya.</p>

            <div class="row">
              @foreach($tahapanOpsional as $tahap)
                <div class="col-md-6 mb-2">
                  <div class="d-flex align-items-center justify-content-between border rounded p-2 shadow-sm bg-light">
                    <div class="d-flex align-items-center">
                      <input type="checkbox" 
                             name="tahapan_opsional[]" 
                             value="{{ $tahap->id }}" 
                             data-nama="{{ $tahap->nama_tahapan }}" 
                             id="tahap_{{ Str::slug($tahap->nama_tahapan, '_') }}" 
                             class="form-check-input me-2 tahapan-checkbox">
                      <label class="form-check-label fw-semibold" for="tahap_{{ Str::slug($tahap->nama_tahapan, '_') }}">
                        {{ $tahap->nama_tahapan }}
                      </label>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>

            <div id="containerTahapanLanjutan" class="mt-4"></div>
          </div>
        </div>
      </div>

      <hr>

      {{-- Total Persentase --}}
      <div class="mt-4 text-end">
        <span class="fw-semibold me-2">Total Persentase:</span>
        <span id="totalPersen" class="fw-bold text-primary">0%</span>
      </div>

      <div class="mt-4 text-end">
        <button type="submit" class="btn btn-success">Buat</button>
      </div>
    </form>
  </div>
</div>


{{-- === SCRIPT === --}}
<script>

document.addEventListener('DOMContentLoaded', () => {

      // === PERIZINAN YANG VALID DARI PO ===
  const poPerizinan = @json($poPerizinan).map(Number);
  console.log("Perizinan dari PO:", poPerizinan);

  const totalText = document.getElementById('totalPersen');
  const containerTahapan = document.getElementById('containerTahapanLanjutan');
  const collectCheckboxes = document.querySelectorAll('.collect-checkbox');
  let order = 0;

  // === Hitung Total Persentase ===
  function updateTotal() {
    let total = 0;
    const surveyVal = parseFloat(document.querySelector('input[name="persentase_survey"]')?.value) || 0;
    total += surveyVal;
    document.querySelectorAll('input[name^="persentase_opsional"]').forEach(el => {
      total += parseFloat(el.value) || 0;
    });
    totalText.textContent = total + '%';
    totalText.classList.toggle('text-danger', total !== 100);
  }

  // === Sub Survey Handler ===
  function updateSubSurvey() {
    const persenUtama = parseFloat(document.querySelector('#persenSurveyUtama')?.value) || 0;
    let totalSub = 0;
    document.querySelectorAll('.persen-sub').forEach(input => totalSub += parseFloat(input.value) || 0);
    const totalSubSurvey = document.getElementById('totalSubSurvey');
    if (totalSubSurvey) {
      totalSubSurvey.textContent = totalSub + '%';
      totalSubSurvey.classList.toggle('text-danger', totalSub !== 100);
    }
    document.querySelectorAll('.persen-sub').forEach(input => {
      const riil = ((parseFloat(input.value) || 0) * persenUtama / 100).toFixed(2);
      input.closest('tr').querySelector('.nilai-riil').textContent = riil + '%';
    });
    updateTotal();
  }

  // === Checkbox Tahapan Opsional ===
document.querySelectorAll('.tahapan-checkbox').forEach(cb => {
  cb.addEventListener('change', function() {
    const tahapId = this.value;
    const tahapNama = this.dataset.nama;
    const slug = this.id.replace('tahap_', '');
    const existing = document.getElementById('form_' + slug);

    if (this.checked) {

      // 🆕 Tambahkan hidden input sesuai urutan klik
      let hidden = document.createElement('input');
      hidden.type = 'hidden';
      hidden.name = 'tahapan_input[]';
      hidden.value = slug;
      hidden.id = 'hidden_' + slug;
      containerTahapan.appendChild(hidden);

      let html = '';

      if (tahapNama.toLowerCase() === 'survey') {
        html = `
          <div id="form_${slug}" class="card shadow-sm mb-3 border-start border-4 border-primary">
            <div class="card-body py-3">
              <h6 class="fw-bold text-primary mb-2">Survey</h6>
                <div class="row g-2 align-items-center">
                  <div class="col-md-5">
                    <label class="form-label fw-semibold small mb-1">Rencana (Start - End)</label><br>
                    <input type="date" name="rencana_mulai[survey]" class="form-control form-control-sm d-inline-block w-auto"> -
                    <input type="date" name="rencana_selesai[survey]" class="form-control form-control-sm d-inline-block w-auto">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label fw-semibold small mb-1">Persentase (%)</label>
                    <input type="number" id="persenSurveyUtama" name="persentase_survey" class="form-control form-control-sm persen-input" min="0" max="100" value="0">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label fw-semibold small mb-1">Petugas</label>
                    <td><textarea name="personil[survey]" class="form-control form-control-sm" rows="1" placeholder="Nama petugas"></textarea></td>
                  </div>
                </div>
        `;
      } else {
        html = `
          <div id="form_${slug}" class="card shadow-sm mb-3 border-start border-4 border-primary">
            <div class="card-body py-3">
              <h6 class="fw-bold text-primary mb-2">${tahapNama}</h6>
              <div class="row g-2 align-items-center">
                <div class="col-md-5">
                  <label class="form-label fw-semibold small mb-1">Rencana (Start - End)</label><br>
                  <input type="date" name="rencana_mulai_opsional[${slug}]" class="form-control form-control-sm d-inline-block w-auto"> -
                  <input type="date" name="rencana_selesai_opsional[${slug}]" class="form-control form-control-sm d-inline-block w-auto">
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-semibold small mb-1">Persentase (%)</label>
                  <input type="number" name="persentase_opsional[${slug}]" class="form-control form-control-sm persen-input" min="0" max="100" value="0">
                </div>
              </div>
            </div>
          </div>
        `;
      }

      containerTahapan.insertAdjacentHTML('beforeend', html);
      updateTotal();

      document.querySelectorAll('.persen-sub').forEach(el => el.addEventListener('input', updateSubSurvey));
      document.querySelector('#persenSurveyUtama')?.addEventListener('input', () => { updateSubSurvey(); updateTotal(); });
      document.querySelectorAll('input[name^="persentase_opsional"]').forEach(el => el.addEventListener('input', updateTotal));
    } else {

      // 🆕 Hapus hidden input ketika uncheck
      let hiddenRemove = document.getElementById('hidden_' + slug);
      if (hiddenRemove) hiddenRemove.remove();

      if (existing) existing.remove();
      updateTotal();
    }
  });
});

// === Collect Dokumen: Validasi + Urutan Klik ===
collectCheckboxes.forEach(cb => {
  cb.addEventListener('change', () => {

    const selectedId = parseInt(cb.value);
    const badge = cb.closest('.form-check').querySelector('.order-badge');

    // === VALIDASI: apakah perizinan ini milik PO? ===
    if (!poPerizinan.includes(selectedId)) {

      cb.closest('.form-check').classList.add('border', 'border-danger');
      alert("⚠ Jenis perizinan yang dipilih TIDAK sesuai dengan perizinan di PO!");
      
      cb.checked = false; // batalin centang

      // hilangkan border merah
      setTimeout(() => {
        cb.closest('.form-check').classList.remove('border', 'border-danger');
      }, 1000);

      return; // STOP → urutan tidak dijalankan
    }

    // === Sesuai PO → proses normal ===
    cb.closest('.form-check').classList.remove('border', 'border-danger');

    if (cb.checked) {
      order++;
      cb.dataset.order = order;
      badge.textContent = order;
      badge.classList.remove('d-none');
      badge.classList.replace('bg-secondary', 'bg-primary');

    } else {

      const removedOrder = parseInt(cb.dataset.order);
      cb.dataset.order = '';

      badge.classList.add('d-none');
      badge.textContent = '0';
      badge.classList.replace('bg-primary', 'bg-secondary');

      collectCheckboxes.forEach(other => {
        if (other.checked && other.dataset.order > removedOrder) {
          other.dataset.order = parseInt(other.dataset.order) - 1;
          const b = other.closest('.form-check').querySelector('.order-badge');
          b.textContent = other.dataset.order;
        }
      });

      order--;
    }

  });
});
});
</script>
@endsection
