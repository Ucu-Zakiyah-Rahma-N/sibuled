<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $table = 'trackings'; // pastikan nama tabel benar
    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

        public function customer() {
        return $this->belongsTo(Customer::class);
    }
    public function tahapan()
    {
        return $this->belongsTo(MstTahapan::class, 'tahapan_id');
    }

}
