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
            $table->enum('law', ['44-ФЗ', '223-ФЗ'])->default('44-ФЗ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demand_files', function (Blueprint $table) {
            $table->string('law')->default('44-ФЗ');
        });
    }
};
