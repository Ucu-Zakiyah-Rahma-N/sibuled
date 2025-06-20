<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profile_id = Auth::user()->profile->id;
        $data = [
            'title' => 'My Profile',
            'profile' => Profile::findOrFail($profile_id)
        ];
        return view('profile', $data);
    }

    public function update(Request $request)
    {

        $ttd = null;
        if($request->hasFile('ttd')){
            if(Auth::user()->profile->ttd !== null){
                Storage::delete(Auth::user()->profile->ttd);
            }
            $ttd = $request->file('ttd')->store('uploads');
        }

        $id_profile = Auth::user()->profile->id;

        Profile::where('id', $id_profile)->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'golongan' => $request->golongan,
            'ttd' => $ttd
        ]);

        return back()->with('success', 'Berhasil Menyimpan Perubahan');
    }

    public static function getNama():string{
        return Auth::user()->profile->nama;       
    }
}
