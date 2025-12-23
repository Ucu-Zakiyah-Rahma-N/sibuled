<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    
    protected $table = 'customers'; // pastikan nama tabel benar
    protected $guarded = ['id'];
    protected $casts = ['pic_perusahaan' => 'array'];

    public function users() {
    return $this->hasMany(User::class, 'customer_id');
    }

    public function marketing()
    {
        return $this->belongsTo(Marketing::class, 'marketing_id');
    }
        public function provinsi()
    {
        return $this->belongsTo(Wilayah::class, 'provinsi_id', 'kode')
            ->where('jenis', 'provinsi');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Wilayah::class, 'kabupaten_id', 'kode')
            ->where('jenis', 'kabupaten');
    }


    public function kawasan_industri()
    {
        return $this->belongsTo(KawasanIndustri::class, 'kawasan_id', 'id');
    }

    public function quotations()
{
    return $this->hasMany(Quotation::class, 'customer_id');
}

        public function po()
    {
        return $this->hasMany(PO::class);
    }


    // Ambil semua project lewat PO
    public function projects()
    {
        return $this->hasManyThrough(Project::class, PO::class, 'customer_id', 'po_id', 'id', 'id');
    }
}

