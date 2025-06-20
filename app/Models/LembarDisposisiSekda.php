<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LembarDisposisiSekda extends Model
{
    protected $table = 'lembar_disposisi_sekda';
    protected $guarded = ['id'];

    public function surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class, 'surat_id', 'id');
    }

    public function bagian()
    {
        return $this->belongsTo(Bagian::class, 'ditujukan', 'id');
    }
}
