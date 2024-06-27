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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('juridical_address');
            $table->string('postal_address');
            $table->string('inn');
            $table->string('account_number');
            $table->string('bank_account');
            $table->string('bik');
            $table->string('ogrn');
            $table->string('email');
            $table->string('phone');
            $table->unsignedBigInteger('status_id')->default(1);
            $table->date('paid_until')->nullable();
            $table->uuid('confirmation_uuid')->unique();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('organization_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
