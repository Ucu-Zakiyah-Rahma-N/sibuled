<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPerizinan extends Model
{
    protected $table = 'project_perizinan';
    protected $guarded = ['id'];
    
    public function perizinan()
    {
        return $this->belongsTo(Perizinan::class, 'perizinan_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
