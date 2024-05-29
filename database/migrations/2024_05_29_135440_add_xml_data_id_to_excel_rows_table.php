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
        Schema::table('excel_rows', function (Blueprint $table) {
            $table->unsignedBigInteger('xml_data_id')->nullable()->after('found');
            $table->foreign('xml_data_id')->references('id')->on('xml_data')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('excel_rows', function (Blueprint $table) {
            $table->dropForeign(['xml_data_id']);
            $table->dropColumn('xml_data_id');
        });
    }
};
