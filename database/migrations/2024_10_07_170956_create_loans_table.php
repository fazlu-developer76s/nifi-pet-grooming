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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->integer('loan_request_id');
            $table->string('loan_number');
            $table->string('amount');
            $table->string('rate_of_interest');
            $table->string('frequency');
            $table->string('tenure');
            $table->string('process_charge');
            $table->string('file_charge');
            $table->string('other_charges_1');
            $table->string('other_charges_2');
            $table->string('other_charges_3');
            $table->string('other_charges_4');
            $table->string('other_charges_5');
            $table->tinyInteger('loan_status')->comment('1-Pending,2-Approvad but not disbursed,3-Disbursed,4-Reject')->default(1);
            $table->tinyInteger('status')->comment('1-Active,2-InActive,3-Deleted,4-Permanent Deleted')->default(10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
