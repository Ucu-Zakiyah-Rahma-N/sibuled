<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sub_tahapan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tahapan_id');
            $table->string('nama_sub');
            $table->integer('persentase_default')->default(100);
            $table->timestamps();

            $table->foreign('tahapan_id')->references('id')->on('tahapan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_tahapan');
    }
};
