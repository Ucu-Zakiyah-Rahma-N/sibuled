<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quotation_templates', function (Blueprint $table) {
            $table->id();
            $table->string('kode_template', 50)->unique(); // DED, PBG, SLF
            $table->string('nama_template');               // Template SPH DED
            $table->string('file_path');                   // templates/sph_ded.docx
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_templates');
    }
};
