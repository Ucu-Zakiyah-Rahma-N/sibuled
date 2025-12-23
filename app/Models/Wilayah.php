<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayahs';
    protected $guarded = ['id'];
    
    public function perizinan() {
        return $this->belongsTo(Customer::class);
    }
}
