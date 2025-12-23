<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KawasanIndustri extends Model
{
    use HasFactory;

    protected $table = 'kawasan_industri';
    protected $guarded = ['id'];

    public function kabupaten()
    {
        return $this->belongsTo(Wilayah::class, 'kabupaten_kode', 'kode');
    }

}
