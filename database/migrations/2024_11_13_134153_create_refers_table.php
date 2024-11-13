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
        Schema::create('refers', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code');
            $table->tinyInteger('code_type')->default(1)->comment("1-Flat,2-Percent");
            $table->string('value');
            $table->tinyInteger('status')->default(1)->comment("1-Active,2-InActive,3-Deleted");
            $table->tinyInteger('is_used_coupon')->default(2)->comment("1-Used,2-Unused");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refers');
    }
};
