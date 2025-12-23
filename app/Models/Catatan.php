<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    use HasFactory;

    protected $table = 'catatan';

    protected $fillable = [
        'project_id', 'tahapan_id', 'user_id', 'isi_catatan'
    ];

        public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tahapan()
    {
        return $this->belongsTo(Tahapan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
