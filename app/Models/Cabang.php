<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cabang extends Model
{
    protected $table = 'cabang';
    protected $fillable = ['nama_cabang', 'kode_sph', 'status'];

    public function quotations() {
        return $this->hasMany(Quotation::class);
    }
}
