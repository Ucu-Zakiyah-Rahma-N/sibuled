<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\StatusSurat;
use App\Models\Surat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SuratKeluarController extends Controller
{
 public function index(Request $request)
    {
        $userBagianId = Auth::user()->bagian->id;

        $query = Surat::query()
            ->where(function ($q) use ($userBagianId) {
                // Assuming 'bagian_id' in the Surat model refers to the sender's bagian for outgoing letters
                $q->where('bagian_id', $userBagianId);
            });

        // Apply filters using when()
        $query->when($request->filled(['startDate', 'endDate']), function ($q) use ($request) {
            $q->whereBetween('tgl_surat', [$request->startDate, $request->endDate]);
        });

        // Note: For 'surat_keluar', filtering by 'bagian' might imply filtering by the *recipient's* bagian.
        // If 'bagian_id' in the filter refers to the sender's bagian, this condition might be redundant
        // with the initial `where('bagian_id', $userBagianId)` unless you allow users to see other bagian's outgoing mail.
        // If it refers to recipients, you'd need a relationship for 'penerima_bagian_id' or similar.
        // For now, I'll assume 'bagian' in the filter refers to the sender's bagian.
        $query->when($request->filled('bagian'), function ($q) use ($request) {
            $q->where('bagian_id', $request->bagian);
        });

        $query->when($request->filled('tipe'), function ($q) use ($request) {
            $q->where('tipe', $request->tipe);
        });

        $query->when($request->filled('nomor'), function ($q) use ($request) {
            $q->where('nomor', 'like', '%' . $request->nomor . '%');
        });

        // --- Changes for Pagination ---
        $surat_keluar = $query->with(['penerima', 'statusTerakhir'])
                             ->orderBy('created_at', 'desc')
                             ->paginate(10); // Adjust 10 to the number of items per page you want

        $data = [
            'title' => 'Surat Keluar',
            // Assuming 'bagian' here is for filtering recipients, it should exclude the current user's bagian.
            'bagian' => Bagian::where('id', '!=', $userBagianId)->get(),
            'request' => $request,
            'surat_keluar' => $surat_keluar // This is now a Paginator instance
        ];

        return view('pages.surat_keluar.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Buat Surat Keluar',
            'bagian' => Bagian::select('id', 'nama_bagian')->where('id', '!=', Auth::user()->bagian->id)->get()
        ];

        return view('pages.surat_keluar.create', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe' => ['nullable', 'in:umum,permohonan'],
            'ditujukan' => ['required', 'exists:bagian,id'],
            'nomor' => ['required', 'string', 'max:255'],
            'sifat' => ['required', 'in:biasa,penting,segera,amat segera'],
            'lampiran' => ['nullable', 'string', 'max:255'],
            'perihal' => ['required', 'string', 'max:255'],
            'tgl_surat' => ['required', 'date'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:3072'], // max:3072 = 3MB
        ], [
            'tipe.in' => 'Tipe surat harus salah satu dari: umum atau permohonan.',
            'ditujukan.required' => 'Tujuan surat harus dipilih.',
            'ditujukan.exists' => 'Tujuan tidak ditemukan dalam data bagian.',
            'nomor.required' => 'Nomor surat harus diisi.',
            'nomor.max' => 'Nomor maksimal 255 karakter.',
            'sifat.required' => 'Sifat surat harus dipilih.',
            'sifat.in' => 'Sifat surat tidak valid.',
            'lampiran.max' => 'Lampiran maksimal 255 karakter.',
            'perihal.required' => 'Perihal surat harus diisi.',
            'perihal.max' => 'Perihal maksimal 255 karakter.',
            'tgl_surat.required' => 'Tanggal surat wajib diisi.',
            'tgl_surat.date' => 'Format tanggal tidak valid.',
            'file.required' => 'File surat harus diunggah.',
            'file.mimes' => 'File harus berupa PDF.',
            'file.max' => 'Ukuran file maksimal 3 MB.',
        ]);

        $filePath = null;
        // if ($request->hasFile('file')) {
        //     $file = $request->file('file');
        //     $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        //     $filePath = $file->storeAs('surat', $filename, 'public');
        // }
        $file = $request->file('file');
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('surat', $filename, 'public');

        $surat = new Surat();
        $surat->tipe = $validated['tipe'];
        $surat->ditujukan = $validated['ditujukan'];
        $surat->nomor = $validated['nomor'];
        $surat->sifat = $validated['sifat'];
        $surat->lampiran = $validated['lampiran'] ?? null;
        $surat->perihal = $validated['perihal'];
        $surat->tgl_surat = $validated['tgl_surat'];
        $surat->file = $filePath;
        $surat->bagian_id = Auth::user()->bagian->id;

        $bagian_id = Auth::user()->bagian->id;
        $penerima = Bagian::where('id', '=', $surat->ditujukan)->value('nama_bagian');

        $statusSurat = new StatusSurat();
        $statusSurat->bagian_id = $bagian_id;
        $statusSurat->status = 'menunggu diterima oleh ' . $penerima;
        $statusSurat->color = 'warning';

        DB::transaction(function () use ($surat, $statusSurat) {
            $surat->save();
            $statusSurat->surat_id = $surat->id;
            $statusSurat->save();
        });

        return redirect('surat_keluar')->with('success', 'Surat berhasil dikirim');
    }

    public function edit($id)
    {
        $surat = Surat::where('id', $id)
            ->where('bagian_id', Auth::user()->bagian->id)
            ->firstOrFail();

        if ($surat->tgl_diterima !== null) {
            return back();
        }

        $data = [
            'title' => 'Edit Surat Keluar',
            'bagian' => Bagian::select('id', 'nama_bagian')->where('id', '!=', Auth::user()->bagian->id)->get(),
            'surat' => $surat
        ];
        
        if(Auth::user()->bagian->nama_organisasi == 'BUMD'){
            return view ('pages.bumd.surat_keluar_edit', $data);      
      }

        return view('pages.surat_keluar.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipe'       => 'nullable',
            'nomor'      => 'required|string',
            'sifat'      => 'required|in:biasa,penting,segera,amat segera',
            'lampiran'   => 'required|string',
            'perihal'    => 'required|string',
            'tgl_surat'  => 'required|date',
            'file'       => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $surat = Surat::where('id', $id)
            ->where('bagian_id', Auth::user()->bagian->id)
            ->firstOrFail();

        $surat->tipe      = $request->tipe;
        $surat->nomor     = $request->nomor;
        $surat->sifat     = $request->sifat;
        $surat->lampiran  = $request->lampiran;
        $surat->perihal   = $request->perihal;
        $surat->tgl_surat = $request->tgl_surat;

        // Jika ada file baru diunggah
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($surat->file && Storage::exists('public/' . $surat->file)) {
                Storage::delete('public/' . $surat->file);
            }

            // Simpan file baru
            $file = $request->file('file')->store('surat_keluar', 'public');
            $surat->file = $file;
        }

        $surat->save();

        return redirect('surat_keluar')->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function show($id)
    {
        $surat = Surat::where('id', $id)
            ->firstOrFail();
        $data = [
            'title' => 'Detail Surat Keluar',
            'status_surat' => StatusSurat::where('surat_id', '=', $id)->get(),
            'surat' => $surat
        ];

        return view('pages.surat_keluar.show', $data);
    }

    public function download($id)
    {
        $surat = Surat::findOrFail($id);
        $filePath = storage_path('app/public/' . $surat->file);

        return response()->download($filePath);
    }
}
