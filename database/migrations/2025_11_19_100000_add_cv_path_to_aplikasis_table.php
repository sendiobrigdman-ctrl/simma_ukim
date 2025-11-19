<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aplikasis', function (Blueprint $table) {
            $table->string('cv_path')->nullable()->after('status_aplikasi');
        });
    }

    public function down(): void
    {
        Schema::table('aplikasis', function (Blueprint $table) {
            $table->dropColumn('cv_path');
        });
    }
};
