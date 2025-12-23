<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahapan extends Model
{
    protected $table = 'tahapan'; // pastikan nama tabel benar
    protected $guarded = ['id'];

        public function projectTahapan()
    {
        return $this->hasMany(ProjectTahapan::class);
    }

    // Model Tahapan.php
public function subTahapan()
{
    return $this->hasMany(SubTahapan::class, 'tahapan_id'); // pastikan kolom fk benar
}


}
