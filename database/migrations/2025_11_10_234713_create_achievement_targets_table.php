<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('achievement_targets', function (Blueprint $table) {
            $table->id();
            $table->string('bulan');
            $table->year('tahun');
            $table->bigInteger('target')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievement_targets');
    }
};
