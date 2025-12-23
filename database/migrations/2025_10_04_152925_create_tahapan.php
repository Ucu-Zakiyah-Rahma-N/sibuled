<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tahapan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tahapan');
            $table->boolean('is_subsurvey')->default(false); // apakah tahapan punya sub survey (arsitektur, struktur, mep)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahapan');
    }
};
