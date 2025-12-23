<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstTahapan extends Model
{
    protected $table = 'mst_tahapans'; // pastikan nama tabel benar
    protected $guarded = ['id'];

    public function tracking()
    {
        return $this->hasMany(Tracking::class, 'tahapan_id');
    }

}
