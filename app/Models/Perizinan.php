<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perizinan extends Model
{
    use HasFactory;

    protected $table = 'perizinans'; // pastikan nama tabel benar
    protected $guarded = ['id'];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function quotation() {
        return $this->belongsToMany(Quotation::class, 'quotation_perizinan')
                    ->withPivot('harga_satuan')
                    ->withTimestamps();
    }
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    public function po() {
    return $this->belongsTo(PO::class);
    }
    public function verifikasi() {
        return $this->hasMany(VerifikasiTahapan::class);
    }
    public function ceklis_perizinan()
{
    return $this->hasMany(CeklisPerizinan::class, 'perizinan_id');
}
public function template()
{
    return $this->hasOne(QuotationTemplate::class, 'kode_template', 'kode');
}


}

