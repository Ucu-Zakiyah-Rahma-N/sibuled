<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTahapan extends Model
{
    protected $table = 'project_tahapan'; // pastikan nama tabel benar
    protected $guarded = ['id'];

    public function tahapan()
    {
        return $this->belongsTo(Tahapan::class, 'tahapan_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function progress()  
    {
        return $this->hasMany(ProjectTahapanProgress::class, 'project_tahapan_id');
    }

    public function latestProgress()
    {
        return $this->hasOne(ProjectTahapanProgress::class, 'project_tahapan_id')->latestOfMany();
    }
    
    public function subTahapan(){
        return $this->hasMany(SubTahapan::class, 'tahapan_id', 'tahapan_id');
    }
    
    public function verifikasi()
    {
        return $this->hasOne(VerifikasiProject::class, 'tahapan_id', 'tahapan_id')
                    ->where('project_id', $this->project_id);
    }



}
