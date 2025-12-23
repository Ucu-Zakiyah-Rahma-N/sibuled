<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Perizinan;
use App\Models\Wilayah;
use App\Models\QuotationPerizinan;
use App\Models\KawasanIndustri;
use App\Models\Cabang;
use App\Models\QuotationTemplate;
use App\Models\MstTahapan;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\Process\Process;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Carbon\Carbon;
use app\Helpers\Terbilang; // kalau pakai package

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $query = Quotation::with(['customer', 'perizinan', 'kawasan_industri'])
            ->orderBy('id', 'DESC');

        // filter
        // 🔹 Filter Kabupaten
        if ($request->filled('kabupaten')) {
            $query->where('kabupaten_id', $request->kabupaten);
        }

        // 🔹 Filter Kawasan
        if ($request->filled('kawasan')) {
            $query->whereHas('kawasan_industri', function ($q) use ($request) {
                $q->where('nama_kawasan', $request->kawasan);
            });
        }

        // 🔹 Filter Perizinan
        if ($request->filled('perizinan')) {
            $query->whereHas('perizinan', function ($q) use ($request) {
                $q->where('jenis', $request->perizinan);
            });
        }

        // 🔹 Filter Cabang
        if ($request->filled('cabang')) {
            $query->where('cabang_id', $request->cabang);
        }

        // 🔹 Search No SPH
        if ($request->filled('search')) {
            $query->where('no_sph', 'like', '%' . $request->search . '%');
        }
        // ✅ paginate + simpan query string
        $quotation = $query->paginate(10)->withQueryString();

        $kabupatenList = Wilayah::where('jenis', 'kabupaten')->pluck('nama', 'kode');

        foreach ($quotation as $q) {
            $q->kabupaten_name = $kabupatenList[$q->kabupaten_id] ?? '-';
            $q->kawasan_name = $q->kawasan_industri->nama_kawasan ?? '-';

            // Olah data luas
            $luasList = [];

            if (!is_null($q->luas_slf)) {
                $formatted = (floor($q->luas_slf) == $q->luas_slf)
                    ? number_format($q->luas_slf, 0, ',', '.')
                    : number_format($q->luas_slf, 2, ',', '.');
                $luasList[] = "SLF: {$formatted} m²";
            }

            if (!is_null($q->luas_pbg)) {
                $formatted = (floor($q->luas_pbg) == $q->luas_pbg)
                    ? number_format($q->luas_pbg, 0, ',', '.')
                    : number_format($q->luas_pbg, 2, ',', '.');
                $luasList[] = "PBG: {$formatted} m²";
            }

            if (!is_null($q->luas_shgb)) {
                $formatted = (floor($q->luas_shgb) == $q->luas_shgb)
                    ? number_format($q->luas_shgb, 0, ',', '.')
                    : number_format($q->luas_shgb, 2, ',', '.');
                $luasList[] = "SHGB: {$formatted} m²";
            }

            $q->luas_info = count($luasList) > 0 ? implode(', ', $luasList) : null;
        }

        $data = [
            'title' => 'Quotation',
            'quotation' => $quotation,
            'customers' => Customer::all(['id', 'nama_perusahaan', 'provinsi_id', 'kabupaten_id', 'detail_alamat']),
            'wilayahs'  => Wilayah::all(),
            'perizinan' => Perizinan::all(),
            'kawasan_industri' => KawasanIndustri::all(), // ✅ tambahan untuk dropdown filter
            'cabang' => Cabang::where('status', 1)->get(),
        ];

        return view('pages.quotation.index', $data);
    }


    public function create()
    {
        $customers = Customer::all();
        $quotations = Quotation::with(['customer', 'perizinan'])->get();
        $provinsiList = Wilayah::where('jenis', 'provinsi')->orderBy('nama')->get();
        $perizinan = Perizinan::all();
        $cabang = Cabang::where('status', 1)->get();

        $data = [
            'title' => 'Form Quotation',
            'customers' => $customers,
            'quotations' => $quotations,
            'provinsiList' => $provinsiList,
            'perizinan' => $perizinan,
            'cabang' => $cabang
        ];

        return view('pages.quotation.create', $data);
    }

    public function previewSph($id)
    {
        $cabang = Cabang::findOrFail($id);

        $last = Quotation::where('cabang_id', $id)
            ->orderBy('counter', 'DESC')
            ->first();

        $startNumber = $cabang->start_number ?? 1;

        $counter = $last ? $last->counter + 1 : $startNumber;
        $romawi = [1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

        $bulan = date('n');
        $tahun = date('Y');

        return response()->json([
            "no_sph" => "{$counter}/SP-{$cabang->kode_sph}/{$romawi[$bulan]}/{$tahun}"
        ]);
    }

    public function getCustomer($id)
    {
        try {
            $customer = Customer::find($id);

            if (!$customer) {
                return response()->json(['message' => 'Customer tidak ditemukan'], 404);
            }

            return response()->json([
                'id' => $customer->id,
                'nama_perusahaan' => $customer->nama_perusahaan,
                'provinsi_id' => $customer->provinsi_id,
                'kabupaten_id' => $customer->kabupaten_id,
                'kawasan_id' => $customer->kawasan_id,
                'detail_alamat' => $customer->detail_alamat,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        Log::info('Quotation Store Dipanggil', $request->all());

        // 1️⃣ Validasi input
        $data = $request->validate([
            'customer_id'     => 'required|exists:customers,id',
            'cabang_id'       => 'required|exists:cabang,id',
            // 'no_sph'          => 'required|string|unique:quotations,no_sph',
            'tgl_sph'         => 'required|date',
            'fungsi_bangunan' => 'required|in:-,Fungsi Hunian,Fungsi Keagamaan,Fungsi Usaha,Fungsi Sosial dan Budaya,Fungsi Khusus',
            'nama_bangunan'   => 'nullable|string|max:255',
            'provinsi_id'     => 'nullable|integer',
            'kabupaten_id'    => 'nullable|integer',
            'kawasan_id'      => 'nullable|integer',
            'detail_alamat'   => 'nullable|string|max:1000',
            'is_same_nama_bangunan' => 'nullable|boolean',
            'is_same_alamat' => 'nullable|boolean',
            'lama_pekerjaan'  => 'nullable|integer',
            'jumlah_termin'      => 'required|integer|min:1|max:3',
            'termin'             => 'required|array',
            'termin.*'           => 'numeric|min:1|max:100',
            'perizinan_id'    => 'required|array',
            'perizinan_id.*'  => 'integer|exists:perizinans,id',
            'harga_tipe'      => 'required|in:satuan,gabungan',
            'harga_gabungan'  => 'nullable|numeric|min:0',
        ], [
            'customer_id.required' => 'Customer harus dipilih.',
            'customer_id.exists' => 'Customer tidak valid.',
            'no_sph.required' => 'Nomor SPH wajib diisi.',
            'no_sph.unique' => 'Nomor SPH sudah terdaftar, gunakan nomor lain.',
            'tgl_sph.required' => 'Tanggal SPH wajib diisi.',
            'tgl_sph.date' => 'Format tanggal tidak valid.',
            'lama_pekerjaan.required' => 'Lama Pekerjaan wajib diisi.',
            'termin.required' => 'Termin wajib diisi.',
            'perizinan_id.required' => 'Pilih minimal satu jenis perizinan.',
            'harga_tipe.required' => 'Pilih tipe harga (satuan/gabungan).',
        ]);

        // Ambil cabang
        $cabang = Cabang::find($request->cabang_id);

        // Hitung counter terbaru cabang ini
        $last = Quotation::where('cabang_id', $cabang->id)
            ->orderBy('counter', 'DESC')
            ->first();

        // Gunakan start_number jika belum ada data
        $startNumber = $cabang->start_number ?? 1;

        $newCounter = $last ? $last->counter + 1 : $startNumber;
        $romawi = [1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

        // Generate nomor SPH
        $bulan = date('n');
        $tahun = date('Y');

        $generatedSph = "{$newCounter}/SP-{$cabang->kode_sph}/{$romawi[$bulan]}/{$tahun}";

        // 2️⃣ Ambil input dinamis dari form
        $luas_slf = $request->input('luas_slf', []);
        $luas_pbg = $request->input('luas_pbg', []);
        $luas_shgb = $request->input('luas_shgb', []);
        $harga_satuan = $request->input('harga_satuan', []);

        // 3️⃣ Hitung total luas masing-masing
        $luas_slf_total = !empty(array_filter($luas_slf)) ? array_sum($luas_slf) : null;
        $luas_pbg_total = !empty(array_filter($luas_pbg)) ? array_sum($luas_pbg) : null;
        $luas_shgb_total = !empty(array_filter($luas_shgb)) ? array_sum($luas_shgb) : null;

        //VALIDASI TERMIN HARUS = 100%
        if (array_sum($request->termin) != 100) {
            return back()->withErrors(['termin' => 'Total termin harus 100%'])->withInput();
        }

        // 4️⃣ Simpan ke tabel quotations
        $quotation = Quotation::create([
            ...$data,
            'no_sph' => $generatedSph,
            'counter' => $newCounter,
            'luas_slf' => $luas_slf_total,
            'luas_pbg' => $luas_pbg_total,
            'luas_shgb' => $luas_shgb_total,
            'harga_gabungan' => $data['harga_tipe'] === 'gabungan' ? $data['harga_gabungan'] : null,

        ]);

        // 5️⃣ Simpan harga perizinan ke pivot quotation_perizinan
        foreach ($data['perizinan_id'] as $perizinan_id) {
            QuotationPerizinan::create([
                'quotation_id' => $quotation->id,
                'perizinan_id' => $perizinan_id,
                'harga_satuan' => $data['harga_tipe'] === 'satuan'
                    ? ($harga_satuan[$perizinan_id] ?? 0)
                    : null,
            ]);
        }
        // simpan termin
        $terminList = [];

        foreach ($request->termin as $urutan => $persen) {
            $terminList[] = [
                'urutan' => $urutan,   // supaya mulai dari 1, bukan 0
                'persen' => $persen
            ];
        }
        // simpan ke kolom JSON
        $quotation->update([
            'termin_persentase' => json_encode($terminList)
        ]);


        return redirect()->route('quotation.index')->with('success', 'Quotation berhasil dibuat!');
    }

    public function show($id)
    {
        // Fungsi format angka
        $formatDesimal = function ($angka) {
            if ($angka === null) return '-';

            // Bilangan bulat → tanpa ,00
            if (floor($angka) == $angka) {
                return number_format($angka, 0, ',', '.');
            }

            // Ada desimal → pakai 2 digit
            return number_format($angka, 2, ',', '.');
        };

        $quotation = Quotation::with([
            'customer',
            'provinsi',
            'kabupaten',
            'kawasan_industri',
            'perizinan'
        ])->findOrFail($id);

        // Tentukan luas bangunan yang tersedia
        $luas_bangunan = $quotation->luas_slf ?? $quotation->luas_pbg ?? $quotation->luas_shgb ?? null;


        // Siapkan list perizinan dan harga per item
        $detail_perizinan = [];
        foreach ($quotation->perizinan as $p) {
            $detail_perizinan[] = [
                'nama'  => $p->nama_perizinan,
                'harga' => $quotation->harga_tipe === 'satuan' ? ($p->pivot->harga_satuan ?? 0) : null,
            ];
        }

        // Tentukan nominal total
        if ($quotation->harga_tipe === 'gabungan') {
            $total_harga = $quotation->harga_gabungan ?? 0;
        } else {
            $total_harga = collect($detail_perizinan)->sum('harga');
        }

        // Siapkan data untuk view
        $data = [
            'title'             => 'Detail Quotation / SPH',
            'quotation'         => $quotation,
            'formatDesimal' => $formatDesimal,
        ];

        return view('pages.quotation.show', $data);
    }

    public function edit($id)
    {
        $quotation = Quotation::with(['customer', 'perizinan', 'provinsi', 'kabupaten', 'kawasan_industri'])
            ->findOrFail($id);

        // Tentukan parent dgn benar
        $parentId = $quotation->parent_id ?? $quotation->id;

        // Cari versi terbaru berdasarkan parent_id
        $latest = Quotation::where('parent_id', $parentId)
            ->orWhere('id', $parentId)
            ->orderBy('version', 'desc')
            ->first();
        // Jika id yang diminta bukan versi terbaru → redirect
        if ($latest->id != $id) {
            return redirect()->route('quotation.edit', $latest->id);
        }
        // Setelah ini: $latest adalah quotation terbaru
        $quotation = $latest;

        // Quotation detail (perizinan + harga + luas)
        $quotationPerizinan = QuotationPerizinan::where('quotation_id', $id)->with('perizinan', 'quotation')->get();

        $provinsiList = Wilayah::where('jenis', 'provinsi')->orderBy('nama')->get();
        $customers = Customer::all();
        $perizinan = Perizinan::all();
        $kawasanIndustri = KawasanIndustri::all();

        //ambil data termin
        $terminLama = $quotation->termin_persentase
            ? json_decode($quotation->termin_persentase, true)
            : [];


        $title = 'Edit Quotation';

        return view('pages.quotation.edit', compact(
            'quotation',
            'customers',
            'perizinan',
            'provinsiList',
            'kawasanIndustri',
            'title',
            'quotationPerizinan',
            'terminLama'
        ));
    }

    public function update(Request $request, $id)
    {
        $old = Quotation::findOrFail($id);

        // ==========================
        // TENTUKAN PARENT
        // ==========================
        $parentId = $old->parent_id ?? $old->id;

        // ambil quotation versi 1 (parent asli)
        $parent = Quotation::findOrFail($parentId);

        // ==========================
        // DUPLIKASI DATA
        // ==========================
        $quotation = $old->replicate();

        // hitung versi baru
        $newVersion = $old->version + 1;
        $quotation->version = $newVersion;
        $quotation->parent_id = $parentId;

        // ==========================
        // GENERATE NO SPH (FIX)
        // ==========================
        $parentNo = $parent->no_sph;

        // pisahkan counter dan body
        list($counter, $body) = explode('/', $parentNo, 2);

        // bersihkan SP.RevX jika ada (antisipasi revisi ulang)
        $body = preg_replace('/SP\.Rev\d+-/', 'SP-', $body);


        // versi 1 → tanpa -R
        if ($newVersion === 1) {
            // versi 1 → tetap tanpa revisi
            $quotation->no_sph = $parentNo;
        } else {
            // versi 2 = Rev1, versi 3 = Rev2, dst
            $rev = $newVersion - 1;

            // sisipkan Rev setelah SP
            $body = preg_replace('/^SP-/', "SP.Rev{$rev}-", $body);

            $quotation->no_sph = "{$counter}/{$body}";
        }

        // Update data umum
        $quotation->customer_id = $request->customer_id;
        $quotation->tgl_sph = $request->tgl_sph;
        // $quotation->fungsi_bangunan = $request->fungsi_bangunan;
        $quotation->nama_bangunan = $request->nama_bangunan;
        $quotation->is_same_nama_bangunan = $request->is_same_nama_bangunan;
        $quotation->provinsi_id = $request->provinsi_id;
        $quotation->kabupaten_id = $request->kabupaten_id;
        $quotation->kawasan_id = $request->kawasan_id;
        $quotation->detail_alamat = $request->detail_alamat;
        $quotation->is_same_alamat = $request->is_same_alamat;
        $quotation->lama_pekerjaan = $request->lama_pekerjaan;
        $quotation->harga_tipe = $request->harga_tipe;

        $quotation->harga_gabungan = ($request->harga_tipe == 'gabungan')
            ? ($request->harga_gabungan ?? 0)
            : 0;

        // ------------------------
        // Update Luas perizinan
        // ------------------------
        $luasMap = [
            'SLF'  => 'luas_slf',
            'PBG'  => 'luas_pbg',
            'SHGB' => 'luas_shgb',
        ];

        foreach ($luasMap as $jenis => $field) {
            // input luas untuk jenis ini
            $inputLuas = $request->input($field, []);
            // cek apakah jenis ini dipilih (ada di perizinan_id)
            $dipilih = false;
            foreach ($request->input('perizinan_id', []) as $pid) {
                if (isset($inputLuas[$pid])) {
                    $quotation->$field = $inputLuas[$pid];
                    $dipilih = true;
                    break;
                }
            }
            if (!$dipilih) {
                $quotation->$field = null; // jika tidak ada, set null
            }
        }

        $quotation->save(); // SIMPAN RECORD BARU (VERSI BARU)

        // ------------------------
        // Update pivot perizinan & harga satuan
        // ------------------------
        $perizinanIds = $request->input('perizinan_id', []);

        $pivotData = [];
        foreach ($perizinanIds as $pid) {
            $pivotData[$pid] = [
                'harga_satuan' => ($request->harga_tipe == 'satuan')
                    ? ($request->input("harga_satuan.$pid") ?? 0)
                    : 0,  // jika gabungan → set 0
            ];
        }
        $quotation->perizinan()->sync($pivotData);

        //termin
        if ($request->termin && array_sum($request->termin) != 100) {
            return back()->withErrors(['termin' => 'Total termin harus 100%'])
                ->withInput();
        }
        // ============================
        // SIMPAN TERMIN KE JSON
        // ============================
        $terminList = [];

        if ($request->termin) {
            foreach ($request->termin as $urutan => $persen) {
                $terminList[] = [
                    'urutan' => (int) $urutan,
                    'persen' => (float) $persen,
                ];
            }
        }

        // Simpan ke database
        $quotation->termin_persentase = json_encode($terminList);
        $quotation->jumlah_termin = count($terminList);

        $quotation->save();

        return redirect()->route('quotation.index')->with('success', 'Quotation revisi versi ' . $quotation->version . ' berhasil dibuat!');
    }


    public function destroy($id)
    {
        try {
            $quotation = Quotation::findOrFail($id);
            $quotation->delete();

            return redirect()->route('quotation.index')->with('success', 'Quotation berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus quotation: ' . $e->getMessage());
        }
    }

    public function getByCustomer($id)
    {
        $quotations = \App\Models\Quotation::where('customer_id', $id)
            ->get(['id', 'no_sph']); // cukup ambil id dan no_sph

        return response()->json($quotations);
    }




    //harus nya di atas show
    public function templateIndex()
    {
        $title = 'Template SPH';
        $templates = \App\Models\QuotationTemplate::all();
        $perizinans = \App\Models\Perizinan::all(); // ambil semua kode + jenis

        $path = 'public/templates'; // storage/app/public/templates
        $files = Storage::files($path);

        $quotations = Quotation::with('customer')->latest()->get();
        return view('pages.quotation.template_SPH', compact('quotations', 'title', 'templates', 'files', 'path', 'perizinans'));
    }

    public function storeTemplateSPH(Request $request)
    {
        $request->validate([
            // 'kode_template' => 'required|unique:quotation_templates,kode_template',
            'nama_template' => 'required|string',
            'file' => 'required|mimes:docx|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $filePath = $file->storeAs('templates', $originalName);

        QuotationTemplate::create([
            'kode_template' => $request->kode_template ?: 'Default', // bisa null jika kosong
            'nama_template' => $request->nama_template,
            'file_path' => str_replace('', '', $filePath),
        ]);

        return redirect()->route('template.index')->with('success', 'Template berhasil ditambahkan!');
    }

    public function uploadTemplateSPH(Request $request, $id)
    {
        $template = QuotationTemplate::findOrFail($id);

        $request->validate([
            'kode_template' => 'required|unique:quotation_templates,kode_template,' . $template->id,
            'nama_template' => 'required|string',
            'file' => 'nullable|mimes:docx|max:10240', // file optional
        ]);

        // Jika ada file baru → hapus file lama + simpan baru
        if ($request->hasFile('file')) {
            if ($template->file_path && Storage::exists('' . $template->file_path)) {
                Storage::delete('' . $template->file_path);
            }

            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $filePath = $file->storeAs('templates', $originalName);
            $template->file_path = str_replace('', '', $filePath);
        }

        // Update data lainnya
        $template->kode_template = $request->kode_template;
        $template->nama_template = $request->nama_template;
        $template->save();

        return redirect()->route('template.index')->with('success', 'Template berhasil diperbarui!');
    }

    // ============================
    // DOWNLOAD TEMPLATE
    // ============================
    public function downloadTemplateSPH($id)
    {
        $template = QuotationTemplate::findOrFail($id);
        $file = storage_path('app/public/' . $template->file_path);

        if (file_exists($file)) {
            return response()->download($file, $template->nama_template . '.docx');
        }

        return redirect()->route('template.index')->with('error', 'File tidak ditemukan.');
    }


    // ini yg bener word nya
    // public function download($id)
    // {
    //     // Ambil data quotation + perizinan + template via query builder dari model
    //     $quotationData = Quotation::get_data_template($id); // $id dikirim ke method

    //     if (!$quotationData) {
    //         Log::warning("Download Quotation: Data quotation tidak ditemukan", ['quotation_id' => $id]);
    //         return redirect()->back()->with('error', 'Quotation tidak ditemukan.');
    //     }

    //     // Log seluruh data quotation
    //     Log::info("Download Quotation: Data quotation", [
    //         'data' => $quotationData->toArray()
    //     ]);

    //     // Ambil ID-IDs
    //     $quotationId = $quotationData->quotation_id;
    //     $quotationPerizinanId = $quotationData->quotation_perizinan_id;
    //     $perizinanId = $quotationData->perizinan_id ?? null;

    //     if (!$perizinanId) {
    //         Log::warning("Download Quotation: Perizinan tidak ditemukan", [
    //             'quotation_id' => $quotationId,
    //             'quotation_perizinan_id' => $quotationPerizinanId,
    //             'perizinan_id' => null
    //         ]);
    //         return redirect()->back()->with('error', 'Perizinan tidak ditemukan untuk quotation ini');
    //     }

    //     // Ambil template
    //     $templatePath = storage_path('app/public/' . $quotationData->file_path);

    //     if (!file_exists($templatePath)) {
    //         Log::warning("Download Quotation: Template file tidak ditemukan", [
    //             'quotation_id' => $quotationId,
    //             'quotation_perizinan_id' => $quotationPerizinanId,
    //             'perizinan_id' => $perizinanId,
    //             'template_file' => $quotationData->file_path
    //         ]);
    //         return redirect()->back()->with('error', 'File template tidak ditemukan.');
    //     }

    //     // Log data lengkap sebelum generate file
    //     Log::info("Download Quotation: Ready generate file", [
    //         'quotation_id' => $quotationId,
    //         'quotation_perizinan_id' => $quotationPerizinanId,
    //         'perizinan_id' => $perizinanId,
    //         'kode_template' => $quotationData->kode_template,
    //         'template_file' => $quotationData->file_path
    //     ]);

    //     // Load template Word
    //     $template = new TemplateProcessor($templatePath);

    //     // Set placeholder
    //     $template->setValues([
    //         'tgl_sph'         => $quotationData->tgl_sph ? Carbon::parse($quotationData->tgl_sph)->translatedFormat('d F Y') : Carbon::now()->translatedFormat('d F Y'),
    //         'no_sph'          => $quotationData->no_sph,
    //         'jenis'           => $quotationData->perizinan_jenis,
    //         'nama_customer'   => $quotationData->nama_customer,
    //         'alamat_customer' => $quotationData->detail_alamat ?? $quotationData->alamat_customer ?? '-',
    //         'nama_bangunan'   => $quotationData->nama_bangunan,
    //         'fungsi_bangunan' => $quotationData->fungsi_bangunan,
    //         'lokasi'          => $quotationData->nama_kawasan ?? $quotationData->nama_kabupaten ?? '-',
    //         'luas_bangunan'   => $quotationData->luas_slf ?? $quotationData->luas_pbg ?? $quotationData->luas_shgb ?? '-',
    //         'harga_satuan'    => $quotationData->harga_satuan ?? '-',
    //     ]);

    //     // Nama file aman dari / atau \
    //     $cleanNoSph = preg_replace('/[\/\\\\]/', '_', $quotationData->no_sph);
    //     $fileName = 'Quotation_' . $cleanNoSph . '.docx';

    //     // Download file
    //     return response()->streamDownload(function () use ($template) {
    //         $template->saveAs('php://output');
    //     }, $fileName);
    // }

    public function download($id)
    {
        $quotation = Quotation::with([
            'customer',
            'perizinan',
            'kabupaten',
            'provinsi'
        ])->findOrFail($id);

        //ini ketika sudah semua punya template masing2            
        // $templatePath = storage_path('app/public/' . $quotation->template_path);

        //skrg pake defaurlt yg slf dl
        // Ambil template pertama dari quotation templates yang ada
$templateFile = QuotationTemplate::whereIn(
    'kode_template',
    $quotation->perizinan->pluck('kode')
)->value('file_path');

$templatePath = null;

if ($templateFile && file_exists(storage_path('app/public/' . $templateFile))) {
    $templatePath = storage_path('app/public/' . $templateFile);
} elseif (file_exists(storage_path('app/public/templates/sph_default.docx'))) {
    $templatePath = storage_path('app/public/templates/sph_default.docx');
} else {
    return back()->with('error', 'Template Word tidak ditemukan');
}

$template = new TemplateProcessor($templatePath);

        // ===============================
        // SET DATA
        // ===============================
        $template->setValues([
            'tgl_sph' => Carbon::parse($quotation->tgl_sph)->translatedFormat('d F Y'),
            'no_sph'  => $quotation->no_sph,

            'nama_customer' => strtoupper($quotation->customer->nama_perusahaan),
            'alamat_customer' => $quotation->detail_alamat,

            'nama_bangunan' => $quotation->nama_bangunan,
            'fungsi_bangunan' => $quotation->fungsi_bangunan ?? '-',

            'lokasi' => trim(
                "{$quotation->detail_alamat}, {$quotation->kabupaten->nama}, {$quotation->provinsi->nama}"
            ),

            'jenis_perizinan' => $quotation->jenis_perizinan_text,
            'luas_bangunan'   => $quotation->luas_bangunan_text,

            'total_harga' => number_format($quotation->total_harga, 0, ',', '.'),
            'total_harga_terbilang' => Terbilang::convert($quotation->total_harga),

            'lama_pekerjaan' => $quotation->lama_pekerjaan
        ]);

        // ===============================
        // CLONE PERIZINAN
        // ===============================
        // ===============================
        // CLONE PERIZINAN + ISI HARGA
        // ===============================
        $jumlahIzin = $quotation->perizinan->count();
        $template->cloneRow('izin_no', $jumlahIzin);

        $no = 1;
        foreach ($quotation->perizinan as $izin) {
            $template->setValue("izin_no#{$no}", $no);
            $template->setValue("izin_jenis#{$no}", $izin->jenis);

            if ($quotation->harga_tipe === 'gabungan') {
                // Harga gabungan tampil hanya di baris pertama
                $template->setValue(
                    "izin_harga#{$no}",
                    $no === 1 ? number_format($quotation->harga_gabungan, 0, ',', '.') : ''
                );
            } else {
                // Harga satuan
                $template->setValue(
                    "izin_harga#{$no}",
                    number_format($izin->pivot->harga_satuan, 0, ',', '.')
                );
            }

            $no++;
        }

        // ===============================
        // TOTAL HARGA
        // ===============================
        // Tambahkan placeholder ${izin_total} di Word di bawah tabel
        $totalHarga = $quotation->harga_tipe === 'gabungan'
            ? $quotation->harga_gabungan
            : $quotation->perizinan->sum('pivot.harga_satuan');

        $template->setValue('izin_total', number_format($totalHarga, 0, ',', '.'));


        // ===============================
        // CLONE TERMIN
        // ===============================
        // Ambil data termin
        $termin = json_decode($quotation->termin_persentase ?? '[]');
        if (empty($termin)) {
            $termin = [(object)['urutan' => 1, 'persen' => 100]];
        }

        $terminPlaceholder = [];
        $huruf = range('A', 'Z');
        $jenis_perizinan = $quotation->jenis_perizinan_text; // misal: "SLF, PBG"

        foreach ($termin as $i => $row) {
            $subPoin = [];

            if ($row->persen == 100) {
                $subPoin = [
                    "1. Penawaran disetujui dan data lengkap diserahkan;",
                    "2. Pembayaran senilai {$row->persen}% dari nilai kontrak;",
                    "3. Penerbitan Surat Keterangan oleh PT Simply Dimensi Indonesia"
                ];
            } elseif ($row->persen == 50 && count($termin) == 2) {
                $subPoin = $i === 0
                    ? [
                        "1. Penawaran disetujui dan data lengkap diserahkan;",
                        "2. Pembayaran senilai {$row->persen}% dari nilai kontrak;",
                        "3. Penerbitan Surat Keterangan dalam proses oleh PT Simply Dimensi Indonesia"
                    ]
                    : [
                        "1. Dokumen laporan kajian selesai;",
                        "2. {$jenis_perizinan} telah diterbitkan;",
                        "3. Pembayaran pelunasan {$row->persen}%, total 100%"
                    ];
                // } elseif ($row->persen == 30 && count($termin) == 3) {
            } elseif (count($termin) == 3) {
                // contoh 3 termin 30%-40%-30%
                if ($i == 0) {
                    $subPoin = [
                        "1. Penawaran disetujui dan data lengkap diserahkan;",
                        "2. Pembayaran senilai {$row->persen}% dari nilai kontrak;",
                        "3. Penerbitan Surat Keterangan sedang diproses"
                    ];
                }

                if ($i == 1) {
                    $subPoin = [
                        "1. Dokumen laporan kajian selesai;",
                        "2. Pembayaran senilai {$row->persen}% dari nilai kontrak;",
                        "3. {$jenis_perizinan} diterbitkan"
                    ];
                }

                if ($i == 2) {
                    $subPoin = [
                        "1. Pelunasan pekerjaan;",
                        "2. Pembayaran {$row->persen}% terakhir sehingga menjadi 100%;"
                    ];
                }
            }

            $terminPlaceholder[] = [
                'huruf' => $huruf[$i],
                'judul' => "Pembayaran ke-{$row->urutan}" . ($i === 0 && $row->persen == 50 ? " (Down Payment)" : ""),
                'sub'   => implode("\n", $subPoin) // gabungkan menjadi string
            ];
        }

        // Clone row sesuai jumlah termin
        $template->cloneRow('termin_huruf', count($terminPlaceholder));

        foreach ($terminPlaceholder as $i => $row) {
            $no = $i + 1;
            $template->setValue("termin_huruf#{$no}", $row['huruf']);
            $template->setValue("termin_judul#{$no}", $row['judul']);
            $template->setValue("termin_sub#{$no}", $row['sub']); // satu string dengan line break
        }


        // ===============================
        // DOWNLOAD
        // ===============================
        $fileName = 'SPH_' . preg_replace('/[\/\\\\]/', '_', $quotation->no_sph) . '.docx';
        return response()->streamDownload(fn() => $template->saveAs('php://output'), $fileName);
    }
}
