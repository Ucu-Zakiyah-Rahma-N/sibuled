<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
Schema::create('verifikasi_project', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('project_id');
    $table->unsignedBigInteger('project_perizinan_id')->nullable();
    $table->unsignedBigInteger('ceklis_perizinan_id')->nullable();
    $table->unsignedBigInteger('tahapan_id')->nullable();
    $table->boolean('verified')->default(0);
    $table->timestamp('verified_at')->nullable();
    $table->unsignedBigInteger('verified_by')->nullable();
    $table->timestamps();

    // FK
    $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
    $table->foreign('project_perizinan_id')->references('id')->on('project_perizinan')->onDelete('cascade');
    $table->foreign('ceklis_perizinan_id')->references('id')->on('ceklis_perizinan')->onDelete('set null');
    $table->foreign('tahapan_id')->references('id')->on('tahapan')->onDelete('cascade');
    $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi_project');
    }
};
