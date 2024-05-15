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
        Schema::table('offers', function (Blueprint $table) {
            $table->unsignedBigInteger('file_status_id')->default(1);
            $table->string('excel_file_path')->nullable();

            $table->foreign('file_status_id')->references('id')->on('file_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropForeign(['file_status_id']);
            $table->dropColumn('file_status_id');
            $table->dropColumn('excel_file_path');
        });
    }
};
