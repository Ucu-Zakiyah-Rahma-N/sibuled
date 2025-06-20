<?php

namespace App\Http\Controllers;

use App\Models\KartuDisposisi;
use App\Models\StatusSurat;
use App\Models\Surat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BPKADController extends Controller
{
    public function __construct()
    {
        if(Auth::user()->bagian->id !== 4){
            abort(403, 'Akses ditolak: bukan dari bagian yang diizinkan');
        }
    }
    public function perintahPencairanCreate($id)
    {
        $data = [
            'title' => 'Perintah Pencairan',
            'ks' => KartuDisposisi::findOrFail($id)
        ];

        return view('pages.bpkad.perintah_pencairan_create',$data);
    }

    public function perintahPencairanStore(Request $request)
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
        $statusSurat->status = 'Surat Perintah Pencairan';
        $statusSurat->color = 'success';

        $statusSurat2 = new StatusSurat();
        $statusSurat2->surat_id = $kartuDisposisi->surat_id;
        $statusSurat2->bagian_id = Auth::user()->bagian->id;
        $statusSurat2->status = 'Surat Perintah sudah dibuat BPKAD';
        $statusSurat2->color = 'success';

        DB::transaction(function () use ($kartuDisposisi, $surat, $statusSurat, $statusSurat2) {
            $surat->save();
            $statusSurat->surat_id = $surat->id;
            $kartuDisposisi->surat_perintah_pencairan_id = $surat->id;
            $kartuDisposisi->save();
            $statusSurat->save();
            $statusSurat2->save();
        });

        return redirect('surat_masuk')->with('success', 'Berhasil membuat Perintah Pencairan');
    }

}
