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
        Schema::create('project_tahapan_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_tahapan_id');
            $table->foreignId('sub_tahapan_id')->nullable()->constrained('sub_tahapan')->nullOnDelete(); // ini penting
            $table->datetime('tanggal_update');
            $table->decimal('persentase_actual', 5, 2)->default(0);
            $table->timestamps();

            // relasi ke tabel project_tahapan
            $table->foreign('project_tahapan_id')
                ->references('id')
                ->on('project_tahapan')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_tahapan_progress');
    }
};
