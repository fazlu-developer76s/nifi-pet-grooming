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
        Schema::create('kycs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('users.id');
            $table->integer('loan_request_id')->comment('loan_request.id');
            $table->string('aadhar_no');
            $table->string('pan_no');
            $table->tinyInteger('kyc_status')->comment('1-Pending,2-InProgress,3-Completed,4-Approved,5-Rejected')->default(1);
            $table->tinyInteger('status')->comment('1-Active,2-Deactive,3-delete,4-Permanent Deleted')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kycs');
    }
};
