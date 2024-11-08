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
        Schema::create('emi_collections', function (Blueprint $table) {
            $table->id();
            $table->integer('loan_id')->comment('loans.id');
            $table->integer('agent_id')->comment('users.id');
            $table->integer('emi_amount');
            $table->integer('payment_mode')->comment('payment modes.id');
            $table->string('reference_no')->nullable();
            $table->string('emi_status')->default(1)->comment('1-Pending,2-Paid');
            $table->tinyInteger('status')->comment('1-Active,2-Deactive,3-delete,4-Permanent Deleted')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emi_collections');
    }
};
