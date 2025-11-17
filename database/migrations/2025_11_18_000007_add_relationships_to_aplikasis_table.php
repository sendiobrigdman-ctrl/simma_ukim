<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aplikasis', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->after('id');
            $table->foreignId('lowongan_id')->nullable()->constrained('lowongans')->nullOnDelete()->after('user_id');
            $table->string('status_aplikasi')->default('pending')->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('aplikasis', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['user_id']);
            $table->dropForeignKeyIfExists(['lowongan_id']);
            $table->dropColumn(['user_id', 'lowongan_id', 'status_aplikasi']);
        });
    }
};
