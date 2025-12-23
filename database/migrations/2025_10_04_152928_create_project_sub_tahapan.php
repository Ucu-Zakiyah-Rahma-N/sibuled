<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_sub_tahapan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_tahapan_id')->constrained('project_tahapan')->cascadeOnDelete();
            $table->foreignId('sub_tahapan_id')->constrained('sub_tahapan')->cascadeOnDelete();
            $table->decimal('persentase_actual', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_sub_tahapan');
    }
};
