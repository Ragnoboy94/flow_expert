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
        Schema::create('xml_data', function (Blueprint $table) {
            $table->id();
            $table->string('search_name');
            $table->string('code')->nullable();
            $table->string('mnn_norm_name')->nullable();
            $table->string('dosage_norm_name')->nullable();
            $table->string('lf_norm_name')->nullable();
            $table->boolean('is_dosed')->nullable();
            $table->boolean('is_znvlp')->nullable();
            $table->boolean('is_narcotic')->nullable();
            $table->string('trade_name')->nullable();
            $table->string('pack_1_num')->nullable();
            $table->string('pack_1_name')->nullable();
            $table->string('pack_2_num')->nullable();
            $table->string('pack_2_name')->nullable();
            $table->string('consumer_total')->nullable();
            $table->string('completeness')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_country_code')->nullable();
            $table->string('owner_country_name')->nullable();
            $table->string('num_reg')->nullable();
            $table->date('date_reg')->nullable();
            $table->string('manufacturer_name')->nullable();
            $table->string('manufacturer_country_code')->nullable();
            $table->string('manufacturer_country_name')->nullable();
            $table->timestamp('date_create')->nullable();
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_change')->nullable();
            $table->decimal('price_value', 10, 2)->nullable();
            $table->date('reg_date')->nullable();
            $table->string('reg_num')->nullable();
            $table->string('barcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xml_data');
    }
};
