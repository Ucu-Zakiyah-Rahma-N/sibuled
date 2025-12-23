<?php

namespace App\Http\Controllers;

use App\Models\Marketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Gunakan paginate() agar bisa tampilkan pagination di view
        $marketing = Marketing::orderBy('nama', 'asc')->paginate(10);

        $data = [
            'title' => 'Marketing',
            'marketing' => $marketing,
        ];

        return view('admin.marketing', $data);
    }
}
