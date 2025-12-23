<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_tahapan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('tahapan_id');
            $table->integer('urutan');
            $table->date('rencana_start')->nullable();
            $table->date('rencana_end')->nullable();
            $table->date('actual_start')->nullable();
            $table->date('actual_end')->nullable();
            $table->decimal('persentase_target', 5, 2)->default(0);
            $table->json('petugas')->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('tahapan_id')->references('id')->on('tahapan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_tahapan');
    }
};
