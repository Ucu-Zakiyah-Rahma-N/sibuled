<?php

namespace App\Http\Controllers;

use App\Models\KartuDisposisi;
use App\Models\StatusSurat;
use Illuminate\Support\Facades\Auth;
use App\Models\Surat;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class BUMDController extends Controller
{
public function pengakuanPencairanCreate($id)
    {
        $data = [
            'title' => 'Pengakuan Pencairan',
            'ks' => KartuDisposisi::findOrFail($id)
        ];

        return view('pages.bumd.pengakuan_pencairan_create',$data);
    }

    public function pengakuanPencairanStore(Request $request)
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
        $statusSurat->status = 'Surat Pengakuan Pencairan';
        $statusSurat->color = 'success';

        $statusSurat2 = new StatusSurat();
        $statusSurat2->surat_id = $kartuDisposisi->surat_id;
        $statusSurat2->bagian_id = Auth::user()->bagian->id;
        $statusSurat2->status = 'Surat Pengakuan sudah dibuat ' . Auth::user()->bagian->nama_bagian;
        $statusSurat2->color = 'success';

        DB::transaction(function () use ($kartuDisposisi, $surat, $statusSurat, $statusSurat2) {
            $surat->save();
            $statusSurat->surat_id = $surat->id;
            $kartuDisposisi->surat_pengakuan_pencairan_id = $surat->id;
            $kartuDisposisi->save();
            $statusSurat->save();
            $statusSurat2->save();
        });

        return redirect('surat_masuk')->with('success', 'Berhasil membuat Pengakuan Pencairan');
    }
}
