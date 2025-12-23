<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CeklisPerizinan extends Model
{
    protected $table = 'ceklis_perizinan';
    protected $guarded = ['id'];

    public function perizinan()
{
    return $this->belongsTo(Perizinan::class, 'perizinan_id');
}

}
