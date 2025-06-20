<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\KartuDisposisi;
use App\Models\LembarDisposisiAsda;
use App\Models\LembarDisposisiSekda;
use App\Models\StatusSurat;
use App\Models\Surat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AsdaController extends Controller
{
    public function __construct()
    {
        if(Auth::user()->bagian->id !== 3){
           abort(403, 'Akses ditolak: bukan dari bagian yang diizinkan');
        }
    }

    public function terimaDisposisiSekda($id)
    {
        $disposisiSekda = LembarDisposisiSekda::findOrFail($id);
        $disposisiSekda->tgl_diterima = Carbon::now();
        $statusSurat = new StatusSurat();
        $statusSurat->surat_id = $disposisiSekda->surat_id;
        $statusSurat->bagian_id = Auth::user()->bagian->id;
        $statusSurat->status = 'Diterima oleh Asda';
        $statusSurat->color = 'success';

        DB::transaction(function () use ($disposisiSekda, $statusSurat) {
            $disposisiSekda->save();
            $statusSurat->save();
        });
        return back();
    }

    public function disposisiCreate($id)
    {
        $sudahDiDisposisi = LembarDisposisiAsda::where('surat_id', '=', $id)->exists();
        if($sudahDiDisposisi){
            return back()->with('error', 'Sudah Disiposisikan');
        }
        $data = [
            'title' => 'Disposisi Sekda',
            'surat' => Surat::findOrFail($id)
        ];

        return view('pages.asda.disposisi_create', $data);
    }

        public function disposisiStore(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'surat_id' => ['required'],
            'ditujukan' => ['required'],
            'nomor_agenda' => ['required'],
            'sifat' => ['required'],
            'intruksi' => ['required'],
            'catatan' => ['required'],
        ]);

        $disposisiAsda = new LembarDisposisiAsda();
        $disposisiAsda->surat_id = $validated['surat_id'];
        $disposisiAsda->ditujukan = (int) $validated['ditujukan'];
        $disposisiAsda->nomor_agenda = $validated['nomor_agenda'];
        $disposisiAsda->sifat = $validated['sifat'];
        $disposisiAsda->intruksi = $validated['intruksi'];
        $disposisiAsda->catatan = $validated['catatan'];

        $penerima = Bagian::where('id', '=',(int)$validated['ditujukan'])->value('nama_bagian');
        $statusSurat = new StatusSurat();
        $statusSurat->surat_id = $validated['surat_id'];
        $statusSurat->bagian_id = Auth::user()->bagian->id;
        $statusSurat->status = 'Didisposisikan ke ' . $penerima;
        $statusSurat->color = 'warning';

        DB::transaction(function () use ($disposisiAsda, $statusSurat) {
            $disposisiAsda->save();
            $statusSurat->save();
        });

        return redirect('surat_masuk')->with('success', 'Berhasil Didisposisikan');
    }

    public function disposisiView($id)
    {
        $disposisi = LembarDisposisiAsda::where('id', '=', $id)->firstOrFail();
        $data = [
            'title' => 'Disposisi View',
            'disposisi' => $disposisi
        ];

        return view('pages.asda.disposisi_view', $data);
    }

    public function terimaKartuDisposisi($id)
    {
        $kartuDisposisi = KartuDisposisi::findOrFail($id);
        $kartuDisposisi->tgl_diterima_asda = Carbon::now();
        $statusSurat = new StatusSurat();
        $statusSurat->surat_id = $kartuDisposisi->surat_id;
        $statusSurat->bagian_id = Auth::user()->bagian->id;
        $statusSurat->status = 'Nota Dinas diterima Asda';
        $statusSurat->color = 'success';

        DB::transaction(function () use ($kartuDisposisi, $statusSurat) {
            $kartuDisposisi->save();
            $statusSurat->save();
        });
        return back();
    }

    public function permohonanPencairanCreate($id)
    {
        $data = [
            'title' => 'Permohonan Pencairan',
            'kartu_disposisi_id' => $id
        ];

        return view('pages.asda.permohonan_pencairan_create', $data);
    }

    public function permohonanPencairanStore(Request $request)
    {
        $request->validate([
            'kartu_disposisi_id' => 'required|exists:kartu_disposisi,id',
            'ditujukan'          => 'required|integer',
            'nomor'              => 'required|string|max:255',
            'sifat'              => 'required|string',
            'lampiran'           => 'required|string',
            'perihal'            => 'required|string',
            'tgl_surat'          => 'required|date',
            'file'               => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('surat', 'public');
        }

        $kartuDisposisi = KartuDisposisi::findOrFail($request->kartu_disposisi_id);
  
        $surat = new Surat();
        $surat->ditujukan           = $request->ditujukan;
        $surat->nomor               = $request->nomor;
        $surat->sifat               = $request->sifat;
        $surat->lampiran            = $request->lampiran;
        $surat->perihal             = $request->perihal;
        $surat->tgl_surat           = $request->tgl_surat;
        $surat->file                = $filePath;
        $surat->bagian_id           = Auth::user()->bagian_id;
        $surat->noref               = $kartuDisposisi->surat_id;

        $statusSurat = new StatusSurat();
        $statusSurat->bagian_id = Auth::user()->bagian->id;
        $statusSurat->status = 'Permohonan Pencairan ke BPKAD';
        $statusSurat->color = 'success';

        $statusSurat2 = new StatusSurat();
        $statusSurat2->surat_id = $kartuDisposisi->surat_id;
        $statusSurat2->bagian_id = Auth::user()->bagian->id;
        $statusSurat2->status = 'Permohonan Pencairan ke BPKAD';
        $statusSurat2->color = 'success';

        DB::transaction(function () use ($kartuDisposisi, $surat, $statusSurat, $statusSurat2) {
            $surat->save();
            $statusSurat->surat_id = $surat->id;
            $kartuDisposisi->surat_permohonan_pencairan_id = $surat->id;
            $kartuDisposisi->save();
            $statusSurat->save();
            $statusSurat2->save();
        });

        return redirect('surat_masuk')->with('success', 'Berhasil membuat Permohonan Pencairan');
    }
}
