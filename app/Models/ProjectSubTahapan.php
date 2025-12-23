<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSubTahapan extends Model
{
    use HasFactory;

    protected $table = 'project_sub_tahapan';

    protected $guarded = ['id'];

    public function projectTahapan()
    {
        return $this->belongsTo(ProjectTahapan::class, 'project_tahapan_id');
    }

    public function subTahapan()
    {
        return $this->belongsTo(SubTahapan::class);
    }
}
