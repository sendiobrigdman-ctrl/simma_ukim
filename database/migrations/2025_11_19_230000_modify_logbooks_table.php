<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            if (!Schema::hasColumn('logbooks', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete()->after('id');
            }

            if (!Schema::hasColumn('logbooks', 'tanggal')) {
                $table->date('tanggal')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('logbooks', 'jam_mulai')) {
                $table->time('jam_mulai')->nullable()->after('tanggal');
            }

            if (!Schema::hasColumn('logbooks', 'jam_selesai')) {
                $table->time('jam_selesai')->nullable()->after('jam_mulai');
            }

            if (!Schema::hasColumn('logbooks', 'aktivitas')) {
                $table->longText('aktivitas')->nullable()->after('jam_selesai');
            }

            if (!Schema::hasColumn('logbooks', 'foto_kegiatan_path')) {
                $table->string('foto_kegiatan_path')->nullable()->after('aktivitas');
            }

            if (!Schema::hasColumn('logbooks', 'status')) {
                $table->string('status')->default('pending')->after('foto_kegiatan_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            foreach (['status','foto_kegiatan_path','aktivitas','jam_selesai','jam_mulai','tanggal','user_id'] as $col) {
                if (Schema::hasColumn('logbooks', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
