<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Surat extends Model
{
    protected $table = 'surat';
    protected $guarded = ['id'];

    public function balasan(): BelongsTo
    {
        return $this->belongsTo(Surat::class, 'noref', 'id');
    }

    public function dibalas(): BelongsTo
    {
        return $this->BelongsTo(Surat::class, 'id', 'noref');
    }

    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(Bagian::class, 'bagian_id', 'id');
    }

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(Bagian::class, 'ditujukan', 'id');
    }

    public function status(): HasMany
    {
        return $this->hasMany(StatusSurat::class, 'surat_id', 'id');
    }

    public function statusTerakhir()
    {
        return $this->hasOne(StatusSurat::class, 'surat_id', 'id')->latestOfMany();
    }

    public function disposisiSekda(): HasOne
    {
       return $this->hasOne(LembarDisposisiSekda::class, 'surat_id', 'id');
    }

    public function disposisiAsda(): HasOne
    {
       return $this->hasOne(LembarDisposisiAsda::class, 'surat_id', 'id');
    }

    public function kartuDisposisi(): HasOne
    {
       return $this->hasOne(KartuDisposisi::class, 'surat_id', 'id');
    }


}
