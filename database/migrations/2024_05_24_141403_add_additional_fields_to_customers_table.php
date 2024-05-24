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
        Schema::table('customers', function (Blueprint $table) {
            $table->boolean('order567')->default(false);
            $table->boolean('order450n')->default(false);
            $table->boolean('fz44')->default(false);
            $table->boolean('fz223')->default(false);
            $table->boolean('eaec')->default(false);
            $table->boolean('completed')->default(false);
            $table->boolean('inProgress')->default(false);
            $table->boolean('terminated')->default(false);
            $table->boolean('cancelled')->default(false);
            $table->date('endDate')->nullable();
            $table->date('endDate2')->nullable();
            $table->date('signDate')->nullable();
            $table->date('signDate2')->nullable();
            $table->foreignId('region_id')->nullable()->constrained('regions');
            $table->boolean('noPenalties1')->default(false);
            $table->boolean('noPenalties2')->default(false);
            $table->string('excludedContracts')->nullable();
            $table->boolean('noIndexation')->default(false);
            $table->decimal('variationLimit', 8, 2)->nullable();
            $table->integer('decimalPlaces')->default(2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'order567',
                'order450n',
                'fz44',
                'fz223',
                'eaec',
                'completed',
                'inProgress',
                'terminated',
                'cancelled',
                'endDate',
                'endDate2',
                'signDate',
                'signDate2',
                'region',
                'noPenalties1',
                'noPenalties2',
                'excludedContracts',
                'noIndexation',
                'variationLimit',
                'decimalPlaces'
            ]);
        });
    }
};
