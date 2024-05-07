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
            $table->integer('file_work_id')->nullable();
            $table->string('new_filename')->nullable();
            $table->foreignId('status_id')->default(1)->constrained('file_statuses')->onDelete('cascade');
            $table->integer('count_row')->default(0);
            $table->integer('count_accept')->default(0);
            $table->integer('count_failed')->default(0);
            $table->text('error_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demand_files', function (Blueprint $table) {
            $table->dropColumn(['file_work_id', 'new_filename', 'status_id', 'count_row', 'count_accept', 'count_failed', 'error_description']);
        });
    }
};
