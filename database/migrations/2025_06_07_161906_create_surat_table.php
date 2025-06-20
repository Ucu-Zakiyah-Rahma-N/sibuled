<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bagian_id');
            $table->foreignId('ditujukan')->nullable();
            $table->foreignId('noref')->nullable()->default(null);
            $table->enum('tipe', ['umum', 'permohonan'])->default('umum');
            $table->string('nomor')->nullable();
            $table->string('sifat')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('perihal')->nullable();
            $table->date('tgl_surat')->nullable();
            $table->dateTime('tgl_diterima')->nullable()->default(null);
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
