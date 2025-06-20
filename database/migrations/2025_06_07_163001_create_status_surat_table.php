<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('status_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_id');
            $table->foreignId('bagian_id');
            $table->string('status');
            $table->string('color');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_surat');
    }
};
