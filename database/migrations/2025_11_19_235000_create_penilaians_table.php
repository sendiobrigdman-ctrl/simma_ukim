<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aplikasi_id')->constrained('aplikasis')->onDelete('cascade');
            $table->unsignedTinyInteger('nilai_disiplin');
            $table->unsignedTinyInteger('nilai_kerja');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique('aplikasi_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
