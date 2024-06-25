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
            $table->boolean('is_essential')->default(false)->after('drug_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('excel_rows', function (Blueprint $table) {
            $table->dropColumn('is_essential');
        });
    }
};
