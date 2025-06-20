<?php

namespace App\Http\Controllers;

use App\Models\StatusSurat;
use App\Models\Surat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function login()
    {
        return view('auth.login', ['title' => 'Login']);
    }

    public function auth(Request $request): RedirectResponse
    {

        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required', 'min:8']
        ],[
            'username.required' => 'username tidak boleh kosong',
            'password.required' => 'password tidak boleh kosong',
            'password.min' => 'password minimal 8 karakter',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $request->session()->put('success', 'Selamat Datang ' . ProfileController::getNama());
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
        
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/')->with('success', 'Semoga harimu menyenangkan');
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard',
            'jumlahSuratMasuk' => Surat::where('ditujukan', '=', Auth::user()->bagian->id)
            ->orWhereHas('disposisiSekda', function ($query){ $query->where('ditujukan', Auth::user()->bagian->id);} )
            ->orWhereHas('disposisiAsda', function ($query){ $query->where('ditujukan', Auth::user()->bagian->id);} )
            ->orWhereHas('kartuDisposisi', function ($query){ $query->where('ditujukan', Auth::user()->bagian->id);} )->count(),
            'jumlahSuratKeluar' => Surat::where('bagian_id', Auth::user()->bagian->id)->count()
        ];
        return view('dashboard', $data);
    }

    public function suratDetail($id)
    {
        $surat = Surat::where('id', $id)
                 ->firstOrFail();
        $data = [
            'title' => 'Detail Surat Masuk',
            'status_surat' => StatusSurat::where('surat_id', '=', $id)->get(),
            'surat' => $surat
        ];

        return view('surat_detail', $data);
    }
    
}
