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
            $table->string('release_form')->nullable()->after('item_name');
            $table->unsignedBigInteger('drug_category_id')->nullable()->after('release_form');
            $table->foreign('drug_category_id')->references('id')->on('drug_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('excel_rows', function (Blueprint $table) {
            $table->dropColumn('release_form');
            $table->dropForeign(['drug_category_id']);
            $table->dropColumn('drug_category_id');
        });
    }
};
