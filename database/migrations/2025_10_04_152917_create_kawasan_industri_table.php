<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kawasan_industri', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kawasan');
            $table->string('kabupaten_kode'); // relasi ke tabel wilayahs (kode kabupaten)
            // $table->string('alamat')->nullable();
            // $table->string('pengelola')->nullable();
            // $table->decimal('luas', 10, 2)->nullable(); // hektar
            $table->timestamps();

            $table->foreign('kabupaten_kode')
                  ->references('kode')
                  ->on('wilayahs')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kawasan_industri');
    }
};
