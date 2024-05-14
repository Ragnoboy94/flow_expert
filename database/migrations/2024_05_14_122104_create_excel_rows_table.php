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
        Schema::create('excel_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demand_file_id')->constrained()->onDelete('cascade');
            $table->string('department')->nullable();
            $table->string('item_name')->nullable();
            $table->string('unit')->nullable();
            $table->float('quantity')->nullable();
            $table->float('price')->nullable();
            $table->float('sum')->nullable();
            $table->string('funding_source')->nullable();
            $table->string('found')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excel_rows');
    }
};
