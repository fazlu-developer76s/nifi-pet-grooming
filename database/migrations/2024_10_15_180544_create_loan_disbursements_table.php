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
        Schema::create('loan_disbursements', function (Blueprint $table) {
            $table->id();
            $table->integer('loan_id');
            $table->string('disbursement_amount');
            $table->integer('disbursement_mode')->comment('payment_modes.id');
            $table->string('image')->nullable();
            $table->string('disbursement_date');
            $table->string('remark');
            $table->string('loan_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_disbursements');
    }
};
