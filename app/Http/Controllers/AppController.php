<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\Project;
use App\Helpers\DashboardHelper;


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
            'password' => ['required', 'min:3']
        ],[
            'username.required' => 'username tidak boleh kosong',
            'password.required' => 'password tidak boleh kosong',
            'password.min' => 'password minimal 3 karakter',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $request->session()->put('success', 'Selamat Datang ');

            // ✅ KHUSUS CUSTOMER
            if (strtolower($user->role) === 'customer') {
                return redirect()->route('tracking'); 
                // atau ->route('customer.timeline') kalau mau langsung timeline
            }

            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
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
    $user = Auth::user(); // otomatis ambil user yang login

    // Kalau role-nya customer dan kamu mau ambil datanya dari tabel customer juga
    if ($user->role === 'customer') {
        $customer = Customer::find($user->customer_id);
    } else {
        $customer = null;
    }
        //sementara saja, di taro sebelm semua punya dashboard masing2 
        $summary = [
        'jumlahPO' => 0,
        'nilaiPO' => 0,
        'target' => 0,
        'achievement' => 0,
        'bulan_list' => [],
        'nilai_list' => []
    ];
    
    $rekap = [];


if(in_array(strtolower($user->role), ['superadmin', 'admin marketing', 'ceo',  'direktur', 'manager marketing', 'manager project', 'manager finance']))
{
    $summary = DashboardHelper::getMarketingSummary();
}

if(in_array(strtolower($user->role), ['admin 1', 'admin 2', 'ceo',  'direktur', 'manager marketing', 'manager project', 'manager finance']))
{
    $projects = DashboardHelper::getAllProjects();

    $rekap = DashboardHelper::getProjectRekap($projects);
    // dd($rekap);
}
    return view('dashboard', [
        'title' => 'Dashboard',
        'user' => $user,          // kirim data user login
        'customer' => $customer,  // opsional kalau mau 

        'jumlahPO' => $summary['jumlahPO'],
        'nilaiPO' => $summary['nilaiPO'],
        'targetBulanIni' => $summary['target'],
        'persentaseAchieve' => $summary['achievement'],
        'bulan' => $summary['bulan_list'],
        'nilaiPerBulan' => $summary['nilai_list'],

        'rekap' => $rekap,
    ]);
}

    
}
