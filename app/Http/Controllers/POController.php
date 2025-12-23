<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Perizinan;
use App\Models\PO;
use App\Models\Wilayah;
use App\Models\Quotation;
use App\Models\Cabang;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;

class POController extends Controller
{
    public function index(Request $request)
    {
        $query = PO::with(['customer', 'perizinan', 'quotation.kawasan_industri', 'quotation.perizinan'])
            ->orderBy('id', 'DESC');


        // 🔹 Filter Kabupaten
        if ($request->filled('kabupaten')) {
            $query->whereHas('quotation', function ($q) use ($request) {
                $q->where('kabupaten_id', $request->kabupaten);
            });
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
            $query->whereHas('quotation', function ($q) use ($request) {
                $q->where('cabang_id', $request->cabang);
            });
        }

        // 🔹 Search No SPH
        if ($request->filled('sph')) {
            $query->whereHas('quotation', function ($q) use ($request) {
                $q->where('no_sph', 'like', '%' . $request->sph . '%');
            });
        }

        if ($request->filled('po')) {
            $query->where('no_po', 'like', '%' . $request->po . '%');
        }

        $po = $query->paginate(10)->withQueryString();

        $kabupatenList = Wilayah::where('jenis', 'kabupaten')->pluck('nama', 'kode');

        foreach ($po as $item) {

            // ========== ambil PIC utama dari customer ==========
            $pics = $item->customer->pic_perusahaan ?? [];

            if (is_string($pics)) {
                $decoded = json_decode($pics, true);
                $pics = is_array($decoded) ? $decoded : [];
            }

            $picsCollection = collect($pics);

            // cari PIC utama
            $primary = $picsCollection->firstWhere('utama', true);
            if (!$primary) {
                $primary = $picsCollection->first(); // fallback ke PIC pertama
            }

            // simpan di properti model (biar bisa langsung dipanggil di Blade)
            $item->primary_pic = $primary;
            $item->pic_perusahaan = $picsCollection->all();

            // ===== Tambahkan kabupaten dan kawasan =====
            $item->kabupaten_name = $kabupatenList[$item->quotation->kabupaten_id ?? null] ?? '-';
            $item->kawasan_name   = $item->quotation->kawasan_industri->nama_kawasan ?? '-';

            // ===== Buat format luas seperti di quotation =====
            $luasList = [];

            if (!is_null($item->quotation->luas_slf)) {
                $luasList[] = 'SLF: ' . number_format($item->quotation->luas_slf, 2, ',', '.') . ' m²';
            }
            if (!is_null($item->quotation->luas_pbg)) {
                $luasList[] = 'PBG: ' . number_format($item->quotation->luas_pbg, 2, ',', '.') . ' m²';
            }
            if (!is_null($item->quotation->luas_shgb)) {
                $luasList[] = 'SHGB: ' . number_format($item->quotation->luas_shgb, 2, ',', '.') . ' m²';
            }

            $item->luas_info = count($luasList) > 0 ? implode(', ', $luasList) : '-';
        }

        $data = [
            'title' => 'PO',
            'po' => $po,
            'customers' => Customer::all(['id', 'nama_perusahaan']),
            'quotation' => Quotation::all(['id', 'provinsi_id', 'kabupaten_id', 'kawasan_id', 'detail_alamat']),
            'perizinan' => Perizinan::all(),
            'wilayahs' => Wilayah::all(),
            'cabang' => Cabang::where('status', 1)->get(),
        ];

        return view('pages.PO.index', $data);
    }

    public function create()
    {
        $customers = Customer::all();
        $PO = PO::with(['customer', 'quotation'])->get();
        $wilayahs = Wilayah::all();

        $data = [
            'title' => 'Form PO',
            'customers' => $customers,
            'PO' => $PO,
            'wilayahs' => $wilayahs,
        ];

        return view('pages.PO.create', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quotation_id' => 'required|exists:quotations,id',
            'file' => 'nullable|mimes:pdf|max:10240', // 10MB max
            'no_po' => 'required|string|unique:po,no_po',
            'tgl_po' => 'required|date',
            'nama_pic_keuangan' => 'nullable|string|max:255',
            'kontak_pic_keuangan' => 'nullable|string|max:20',
        ]);
    $filePath = null;

    //  CEK ADA FILE ATAU TIDAK
    if ($request->hasFile('file')) {

        $file = $request->file('file');

        $originalName = $file->getClientOriginalName();
        $cleanName = time() . '_' . str_replace(['(', ')', ' '], '_', $originalName);

        $filePath = $file->storeAs('po', $cleanName, 'public');
    }
        PO::insert([
            'customer_id' => $request->customer_id,
            'quotation_id' => $request->quotation_id,
            'file_path' => $filePath,
            'no_po' => $request->no_po,
            'tgl_po' => $request->tgl_po,
            'nama_pic_keuangan' => $request->nama_pic_keuangan,
            'kontak_pic_keuangan' => $request->kontak_pic_keuangan,
            'bast_verified' => 0,
            'bast_verified_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('PO.index')->with('success', 'Data PO berhasil disimpan.');
    }

    public function verifyBast($id)
    {
        $po = PO::find($id);

        if (!$po) {
            return response()->json(['success' => false, 'message' => 'Data PO tidak ditemukan.'], 404);
        }

        if ($po->bast_verified) {
            return response()->json(['success' => false, 'message' => 'BAST sudah diverifikasi sebelumnya.']);
        }

        $po->update([
            'bast_verified' => 1,
            'bast_verified_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'BAST berhasil diverifikasi.']);
    }
}
