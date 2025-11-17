<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aplikasis', function (Blueprint $table) {
            $table->foreignId('dosen_id')->nullable()->constrained('users')->nullOnDelete()->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('aplikasis', function (Blueprint $table) {
            $table->dropConstrainedForeignId('dosen_id');
        });
    }
};
