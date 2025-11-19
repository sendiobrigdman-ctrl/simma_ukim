<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lowongans', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('created_at');
        });

        // Backfill existing records as approved so current data remains visible
        DB::table('lowongans')->update(['status' => 'approved']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lowongans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
