<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTahapan extends Model
{
    use HasFactory;

    protected $table = 'sub_tahapan';
    protected $guarded = ['id'];

    public function tahapan()
    {
        return $this->belongsTo(Tahapan::class, 'tahapan_id');
    }

    public function verifikasi()
{
    return $this->hasOne(VerifikasiProject::class, 'sub_tahapan_id'); // kalau persentase disimpan di tabel verifikasi
}

}
