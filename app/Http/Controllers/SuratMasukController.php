<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\StatusSurat;
use App\Models\Surat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuratMasukController extends Controller {

    public function index(Request $request)
    {
        $userBagianId = Auth::user()->bagian->id;

        $query = Surat::query()
            ->where(function ($q) use ($userBagianId) {
                $q->where('ditujukan', $userBagianId)
                    ->orWhereHas('disposisiSekda', function ($q) use ($userBagianId) {
                        $q->where('ditujukan', $userBagianId);
                    })
                    ->orWhereHas('disposisiAsda', function ($q) use ($userBagianId) {
                        $q->where('ditujukan', $userBagianId);
                    })
                    ->orWhereHas('kartuDisposisi', function ($q) use ($userBagianId) {
                        $q->where('ditujukan', $userBagianId);
                    });
            });

        // Apply filters using when()
        $query->when($request->filled(['startDate', 'endDate']), function ($q) use ($request) {
            $q->whereBetween('tgl_surat', [$request->startDate, $request->endDate]);
        });

        $query->when($request->filled('bagian'), function ($q) use ($request) {
            // Note: If 'bagian_id' refers to the sender's bagian, and 'ditujukan' is for recipients,
            // ensure this logic is correct for your specific filtering needs.
            $q->where('bagian_id', $request->bagian);
        });

        $query->when($request->filled('tipe'), function ($q) use ($request) {
            $q->where('tipe', $request->tipe);
        });

        $query->when($request->filled('nomor'), function ($q) use ($request) {
            $q->where('nomor', 'like', '%' . $request->nomor . '%');
        });

        // --- Changes for Pagination ---
        $surat_masuk = $query->with(['pengirim', 'statusTerakhir'])
                             ->orderBy('created_at', 'desc')
                             ->paginate(10);

        $data = [
            'title' => 'Surat Masuk',
            'bagian' => Bagian::where('id', '!=', $userBagianId)->get(),
            'request' => $request,
            'surat_masuk' => $surat_masuk
        ];

        // Dynamic view selection based on user's bagian ID
        $viewName = '';
        switch ($userBagianId) {
            case 1:
                $viewName = 'pages.kabag.surat_masuk';
                break;
            case 2:
                $viewName = 'pages.sekda.surat_masuk';
                break;
            case 3:
                $viewName = 'pages.asda.surat_masuk';
                break;
            case 4:
                $viewName = 'pages.bpkad.surat_masuk';
                break;
            default:
                $viewName = 'pages.bumd.surat_masuk'; // Default for other IDs
                break;
        }

        return view($viewName, $data);
    }

    public function diterima($id)
    {
        $surat = Surat::where('id', $id)
        ->where('ditujukan', Auth::user()->bagian->id)
        ->firstOrFail();

        $statusSurat = new StatusSurat();
        $statusSurat->surat_id = $id;
        $statusSurat->bagian_id = Auth::user()->bagian->id;
        $statusSurat->status = 'diterima oleh ' . Auth::user()->bagian->nama_bagian;
        $statusSurat->color = 'success';

        DB::transaction(function() use ($surat, $statusSurat) {
            $surat->update([
                'tgl_diterima' => Carbon::now()
            ]);
            
            $statusSurat->save();
        });

        return back();
    }

    public function show($id)
    {
        // awalnya dibuat untuk validasi agar yang diliat hanya user yang punya akses saja
        $surat = Surat::where('id', $id)
            // ->where('ditujukan', Auth::user()->bagian->id)
            // ->orWhereHas('disposisiSekda', function ($query){ $query->where('ditujukan', Auth::user()->bagian->id);} )
            // ->orWhereHas('disposisiAsda', function ($query){ $query->where('ditujukan', Auth::user()->bagian->id);} )
            // ->orWhereHas('kartuDisposisi', function ($query){ $query->where('ditujukan', Auth::user()->bagian->id);} )
            ->firstOrFail();
        $data = [
            'title' => 'Detail Surat Masuk',
            'status_surat' => StatusSurat::where('surat_id', '=', $id)->get(),
            'surat' => $surat
        ];

        return view('pages.surat_masuk.show', $data);
    }

    public function reply($id)
    {
        $surat = Surat::where('id', $id)
            ->where('ditujukan', Auth::user()->bagian->id)
            ->firstOrFail();
        $data = [
            'title' => 'Balas Surat',
            'surat' => $surat
        ];

        return view('pages.surat_masuk.reply', $data);
    }

    public function replyStore(Request $request)
    {
        $validated = $request->validate([
            'noref' => ['required'],
            'ditujukan' => ['required'],
            'nomor' => ['required'],
            'sifat' => ['required'],
            'lampiran' => ['nullable'],
            'perihal' => ['required'],
            'tgl_surat' => ['required'],
            'file' => ['required'],
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('surat', $filename, 'public');
        }

        $surat = new Surat();
        $surat->noref = $validated['noref'];
        $surat->bagian_id = Auth::user()->bagian->id;
        $surat->ditujukan = $validated['ditujukan'];
        $surat->nomor = $validated['nomor'];
        $surat->sifat = $validated['sifat'];
        $surat->lampiran = $validated['lampiran'];
        $surat->perihal = $validated['perihal'];
        $surat->tgl_surat = $validated['tgl_surat'];
        $surat->file = $filePath;

        $penerima = Bagian::where('id', '=',$surat->ditujukan)->value('nama_bagian');
        $statusSurat = new StatusSurat();
        $statusSurat->bagian_id = Auth::user()->bagian->id;
        $statusSurat->status = 'menunggu diterima oleh ' . $penerima;
        $statusSurat->color = 'warning';

        $statusSurat2 = new StatusSurat();
        $statusSurat2->surat_id = $validated['noref'];
        $statusSurat2->bagian_id = Auth::user()->bagian->id;
        $statusSurat2->status = 'dibalas oleh ' . Auth::user()->bagian->nama_bagian;
        $statusSurat2->color = 'secondary';

        DB::transaction(function () use ($surat, $statusSurat, $statusSurat2) {
            $surat->save();
            $statusSurat->surat_id = $surat->id;
            $statusSurat->save();
            $statusSurat2->save();
        });

        return redirect('surat_keluar')->with('success', 'Berhasil membuat balasan surat');
    }
        public function download($id)
    {
        $surat = Surat::findOrFail($id);
        $filePath = storage_path('app/public/' . $surat->file);

        return response()->download($filePath);
    }
    
}
