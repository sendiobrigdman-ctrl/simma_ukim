<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lowongans', function (Blueprint $table) {
            $table->foreignId('mitra_id')->nullable()->constrained('users')->nullOnDelete()->after('id');
            $table->string('description')->nullable()->after('title');
            $table->string('position')->nullable()->after('description');
            $table->string('location')->nullable()->after('position');
            $table->string('salary')->nullable()->after('location');
        });
    }

    public function down(): void
    {
        Schema::table('lowongans', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['mitra_id']);
            $table->dropColumn(['mitra_id', 'description', 'position', 'location', 'salary']);
        });
    }
};
