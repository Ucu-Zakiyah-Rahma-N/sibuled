<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KartuDisposisi extends Model
{
    protected $table = 'kartu_disposisi';

    protected $guarded = ['id'];

    public function surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class, 'surat_id', 'id');
    }
}
