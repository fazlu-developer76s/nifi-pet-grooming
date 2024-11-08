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
        Schema::create('loan_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('name');
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->string('loan_amount');
            $table->string('reason_of_loan')->nullable();;
            $table->string('referal_name')->nullable();;
            $table->string('referal_mobile')->nullable();;
            $table->string('token')->nullable();
            $table->string('remark')->nullable();
            $table->tinyInteger('loan_status')->default(1)->comment('1-pending,2-viewed,3-processed for kyc,4-disbursed,5-rejected');
            $table->tinyInteger('status')->default(1)->comment('1-Active,2-InActive,3-Deleted,4-Permanent deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_requests');
    }
};
