<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCeklisExclude extends Model
{
    protected $table = 'project_ceklis_exclude';

    protected $fillable = ['project_id', 'project_perizinan_id', 'ceklis_perizinan_id', 'is_active'];

    public function ceklis()
    {
        return $this->belongsTo(CeklisPerizinan::class, 'ceklis_perizinan_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
