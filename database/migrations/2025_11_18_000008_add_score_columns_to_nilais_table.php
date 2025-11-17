<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->integer('nilai_bimbingan')->nullable()->after('value');
            $table->integer('nilai_laporan_akhir')->nullable()->after('nilai_bimbingan');
            $table->integer('nilai_mitra')->nullable()->after('nilai_laporan_akhir');
        });
    }

    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->dropColumn(['nilai_bimbingan', 'nilai_laporan_akhir', 'nilai_mitra']);
        });
    }
};
