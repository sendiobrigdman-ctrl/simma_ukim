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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nim')->nullable()->unique()->after('id');
            $table->string('jurusan')->nullable()->after('email');
            $table->integer('angkatan')->nullable()->after('jurusan');
            $table->decimal('ipk', 3, 2)->nullable()->after('angkatan');
            $table->string('no_hp')->nullable()->after('ipk');
            $table->string('foto_path')->nullable()->after('no_hp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nim', 'jurusan', 'angkatan', 'ipk', 'no_hp', 'foto_path']);
        });
    }
};
