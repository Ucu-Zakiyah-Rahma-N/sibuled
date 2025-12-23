<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ceklis_perizinan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perizinan_id'); // relasi ke tabel perizinans
            $table->string('nama_dokumen');
            $table->timestamps();

            $table->foreign('perizinan_id')
                  ->references('id')
                  ->on('perizinans')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ceklis_perizinan');
    }
};
