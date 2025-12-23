<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketing_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreignId('po_id')->constrained('po')->onDelete('cascade');
            // status proyek
            $table->enum('status', [
                'draft',         // baru dibuat, belum diset tahapan
                'perencanaan',   // tahapan sudah diisi
                'onProcess',      // sedang dikerjakan
                'verifikasi',    // tahap verifikasi dokumen
                'selesai',       // proyek sudah lengkap
            ])->default('draft');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
