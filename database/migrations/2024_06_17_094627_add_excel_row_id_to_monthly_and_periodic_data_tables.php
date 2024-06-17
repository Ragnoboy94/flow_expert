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
        Schema::table('monthly_data', function (Blueprint $table) {
            $table->unsignedBigInteger('excel_row_id')->nullable()->after('user_id');
            $table->foreign('excel_row_id')->references('id')->on('excel_rows')->onDelete('cascade');
        });

        Schema::table('periodic_data', function (Blueprint $table) {
            $table->unsignedBigInteger('excel_row_id')->nullable()->after('user_id');
            $table->foreign('excel_row_id')->references('id')->on('excel_rows')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly_data', function (Blueprint $table) {
            $table->dropForeign(['excel_row_id']);
            $table->dropColumn('excel_row_id');
        });

        Schema::table('periodic_data', function (Blueprint $table) {
            $table->dropForeign(['excel_row_id']);
            $table->dropColumn('excel_row_id');
        });
    }
};
