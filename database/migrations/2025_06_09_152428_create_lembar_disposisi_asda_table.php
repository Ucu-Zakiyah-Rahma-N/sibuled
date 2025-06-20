<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lembar_disposisi_asda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lembar_disposisi_sekda_id')->nullable();
            $table->foreignId('surat_id');
            $table->foreignId('ditujukan'); // bagian_id
            $table->string('nomor_agenda');
            $table->enum('sifat', ['Sangat Segera', 'Segera', 'Rahasia']);
            $table->enum('intruksi', ['Tanggapan dan Saran', 'Proses lebih lanjut', 'Koordinasi/Konfirmasikan']);
            $table->text('catatan')->nullable()->default(null);
            $table->dateTime('tgl_diterima')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembar_disposisi_asda');
    }
};
