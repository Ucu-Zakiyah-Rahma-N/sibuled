<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quotation;
use App\Models\QuotationPerizinan;
use App\Models\Perizinan;


class QuotationTemplate extends Model
{
    use HasFactory;

    protected $table = 'quotation_templates';

    protected $guarded = ['id'];

    /**
     * Relasi jika kamu ingin
     * mendapatkan semua quotation yang pakai template ini
     */
    public function quotations()
    {
        return $this->hasMany(\App\Models\Quotation::class, 'template_id');
    }
    public function perizinan()
{
    return $this->belongsToMany(Perizinan::class, 'quotation_perizinan', 'quotation_id', 'perizinan_id')
                ->withPivot('harga_satuan')
                ->withTimestamps();
}
}
