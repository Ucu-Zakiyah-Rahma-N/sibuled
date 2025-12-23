<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTahapanProgress extends Model
{
    protected $table = 'project_tahapan_progress';
    protected $fillable = [
    'project_tahapan_id',
    'sub_tahapan_id',
    'tanggal_update',
    'persentase_actual',
    ];

public function projectTahapan() {
    return $this->belongsTo(ProjectTahapan::class);
}

public function subTahapan() {
    return $this->belongsTo(SubTahapan::class);
}
}
