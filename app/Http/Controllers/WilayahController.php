<?php

namespace App\Http\Controllers;
use App\Models\Wilayah;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    public function getKabupaten($provinsiKode)
    {
        $kabupaten = Wilayah::where('parent_kode', $provinsiKode)
                            ->where('jenis', 'kabupaten')
                            ->orderBy('nama')
                            ->get(['kode', 'nama']);
        return response()->json($kabupaten);
    }


public function getKawasan($kabupatenKode)
{
    $kawasan = DB::table('kawasan_industri as k')
        ->join('wilayahs as w', 'k.kabupaten_kode', '=', 'w.kode')
        ->where('k.kabupaten_kode', $kabupatenKode)
        ->orderBy('k.nama_kawasan')
        ->select('k.id', 'k.nama_kawasan', 'k.kabupaten_kode', 'w.nama as kabupaten_nama')
        ->get();

    return response()->json($kawasan);
}
}
