<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\KartuDisposisi;
use App\Models\LembarDisposisiAsda;
use App\Models\LembarDisposisiSekda;
use App\Models\StatusSurat;
use App\Models\Surat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KabagController extends Controller
{
    public function __construct()
    {
        if (Auth::user()->bagian->id !== 1) {
            abort(403, 'Akses ditolak: bukan dari bagian yang diizinkan');
        }
    }

    public function kartuDisposisiCreate($id)
    {
        $data = [
            'title' => 'Kartu Disposisi Create',
            'surat' => Surat::findOrFail($id)
        ];

        return view('pages.kabag.kartu_disposisi_create', $data);
    }

    public function kartuDisposisiStore(Request $request)
    {
        $validated = $request->validate([
            'surat_id' => ['required'],
            'index' => ['required'],
            'tgl_penyelesaian' => ['required'],
            'diteruskan' => ['required'],
            'keputusan' => ['required'],
            'catatan' => ['required'],
        ]);

        $kartuDisposisi = new KartuDisposisi();

        $surat = Surat::findOrFail($validated['surat_id']);

        if ($surat->disposisiSekda) {
            $kartuDisposisi->lembar_disposisi_sekda_id = $surat->disposisiSekda->id;
        }
        if ($surat->disposisiAsda) {
            $kartuDisposisi->lembar_disposisi_asda_id = $surat->disposisiAsda->id;
        }

        $kartuDisposisi->surat_id = (int)$validated['surat_id'];
        $kartuDisposisi->index = $validated['index'];
        $kartuDisposisi->tgl_penyelesaian = $validated['tgl_penyelesaian'];
        $kartuDisposisi->diteruskan = $validated['diteruskan'];
        $kartuDisposisi->keputusan = $validated['keputusan'];
        $kartuDisposisi->catatan = $validated['catatan'];

        $statusSurat = new StatusSurat();
        $statusSurat->surat_id = $validated['surat_id'];
        $statusSurat->bagian_id = Auth::user()->bagian->id;
        $statusSurat->status = 'Dibuatkan Kartu Disposisi';
        $statusSurat->color = 'success';

        DB::transaction(function () use ($kartuDisposisi, $statusSurat) {
            $kartuDisposisi->save();
            $statusSurat->save();
        });

        return redirect('surat_masuk')->with('success', 'Berhasil membuat Kartu Disposisi');
    }

    public function terimaDisposisiSekda($id)
    {
        $disposisiSekda = LembarDisposisiSekda::findOrFail($id);
        $disposisiSekda->tgl_diterima = Carbon::now();
        $statusSurat = new StatusSurat();
        $statusSurat->surat_id = $disposisiSekda->surat_id;
        $statusSurat->bagian_id = Auth::user()->bagian->id;
        $statusSurat->status = 'Diterima oleh Kabag';
        $statusSurat->color = 'success';

        DB::transaction(function () use ($disposisiSekda, $statusSurat) {
            $disposisiSekda->save();
            $statusSurat->save();
        });
        return back();
    }

    public function terimaDisposisiAsda($id)
    {
        $disposisiAsda = LembarDisposisiAsda::findOrFail($id);
        $disposisiAsda->tgl_diterima = Carbon::now();
        $statusSurat = new StatusSurat();
        $statusSurat->surat_id = $disposisiAsda->surat_id;
        $statusSurat->bagian_id = Auth::user()->bagian->id;
        $statusSurat->status = 'Diterima oleh Kabag';
        $statusSurat->color = 'success';

        DB::transaction(function () use ($disposisiAsda, $statusSurat) {
            $disposisiAsda->save();
            $statusSurat->save();
        });
        return back();
    }

    public function kartuDisposisiView($id)
    {

        $data = [
            'title' => 'Kartu Disposisi View',
            'ks' => KartuDisposisi::findOrFail($id)
        ];

        return view('pages.kabag.kartu_disposisi_view', $data);
    }

    public function notaDinasCreate($id)
    {
        $data = [
            'title' => 'Nota Dinas Create',
            'ks' => KartuDisposisi::findOrFail($id)
        ];

        return view('pages.kabag.nota_dinas', $data);
    }

    public function notaDinasStore(Request $request)
    {
        $request->validate([
            'file_nota_dinas' => 'required|file|mimes:pdf|max:3072',
            'kartu_disposisi_id' => 'required|exists:kartu_disposisi,id',
        ]);

        $kartuDisposisi = KartuDisposisi::findOrFail($request->kartu_disposisi_id);

        if ($request->hasFile('file_nota_dinas')) {
            $file = $request->file('file_nota_dinas');
            $path = $file->store('nota_dinas', 'public');

            if ($path) {
                DB::transaction(function () use ($kartuDisposisi, $path) {
                    $kartuDisposisi->file_nota_dinas = $path;
                    $kartuDisposisi->ditujukan = 3;
                    $kartuDisposisi->save();

                    $statusSurat = new StatusSurat();
                    $statusSurat->surat_id = $kartuDisposisi->surat_id;
                    $statusSurat->bagian_id = Auth::user()->bagian->id;
                    $statusSurat->status = 'Dibuatkan Nota Dinas';
                    $statusSurat->color = 'success';
                    $statusSurat->save();
                });

                return redirect('surat_masuk')->with('success', 'Nota Dinas berhasil diunggah.');
            } else {
                return redirect()->back()->with('error', 'Gagal mengunggah Nota Dinas. File tidak dapat disimpan.');
            }
        }

        return redirect()->back()->with('error', 'Tidak ada file Nota Dinas yang diunggah.');
    }

    public function finish($id)
    {

        $kartuDisposisi = KartuDisposisi::findOrFail($id);
        $kartuDisposisi->selesai = 1;

        $statusSurat = new StatusSurat();
        $statusSurat->surat_id = $kartuDisposisi->surat_id;
        $statusSurat->bagian_id = Auth::user()->bagian->id;
        $statusSurat->status = 'Ditandai selesai oleh ' . Auth::user()->bagian->nama_bagian;
        $statusSurat->color = 'success';

        DB::transaction(function () use ($kartuDisposisi, $statusSurat) {
            $kartuDisposisi->save();
            $statusSurat->save();
        });

        return redirect('surat_masuk')->with('success', 'Berhasil ditandai Selesai');
    }

    public function userGet()
    {
        $data = [
            'title' => 'User',
            'users' => User::where('bagian_id', '!=', 1)->with('profile', 'bagian')->get()
        ];

        return view('pages.kabag.user', $data);
    }

    public function userCreate()
    {
        $data = [
            'title' => 'User',
            'bagian' => Bagian::where('id', '!=', 1)->get(),
            'users' => User::with('profile', 'bagian')->get()
        ];

        return view('pages.kabag.user_create', $data);
    }

    public function userStore(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'email' => 'required',
            'bagian_id' => 'required',
        ]);

        User::create($validated);

        return back()->with('success', 'Berhasil menambahkan user');
    }

    public function userDetail($id)
    {
        $data = [
            'title' => 'User',
            'bagian' => Bagian::where('id', '!=', 1)->get(),
            'user' => User::findOrFail($id)
        ];

        return view('pages.kabag.user_detail', $data);
    }

    public function userUpdate($id, Request $request)
    {
        $request->validate([
            'username'   => 'required|string|max:100',
            'email'      => 'required|email|max:100',
            'bagian_id'  => 'required|exists:bagian,id',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'username'   => $request->username,
            'email'      => $request->email,
            'bagian_id'  => $request->bagian_id,
        ]);

        return redirect()->back()->with('success', 'Data user berhasil diperbarui');
    }

    public function userDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus']);
    }

    public function ubahPassword($id)
    {
        $data = [
            'title' => 'Ubah Password',
            'user' => User::findOrFail($id)
        ];

        return view('auth.ubah_password', $data);
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        $passwordhash = Hash::make($request->password);

        User::where('id', '=', $id)->update([
            'password' => $passwordhash
        ]);

        return back()->with('success', 'Berhasil mengubah password');
    }

    public function printPdf($id)
    {

        $ks = KartuDisposisi::with('surat.pengirim')->findOrFail($id);

        $pdf = Pdf::loadView('pages.kabag.kartu_disposisi_print', ['ks'=>$ks])
        ->setPaper('a4', 'portrait');
        return $pdf->stream('kartu_disposisi_'.$ks->id.'.pdf');
    }
}
