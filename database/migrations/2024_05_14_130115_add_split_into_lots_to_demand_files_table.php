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
        Schema::table('demand_files', function (Blueprint $table) {
            $table->boolean('split_into_lots')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demand_files', function (Blueprint $table) {
            $table->dropColumn('split_into_lots');
        });
    }
};
