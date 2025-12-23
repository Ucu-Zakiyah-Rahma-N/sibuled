<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifikasiTahapan extends Model
{
    protected $fillable = ['perizinan_id', 'tahapan_id', 'status', 'tanggal_verifikasi'];

    public function perizinan() {
        return $this->belongsTo(Perizinan::class, 'perizinan_id');
    }

    public function tahapan() {
        return $this->belongsTo(MstTahapan::class, 'tahapan_id');
    }

    public function catatan() {
        return $this->hasMany(Catatan::class);
    }
}

