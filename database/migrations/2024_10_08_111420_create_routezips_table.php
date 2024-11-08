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
        Schema::create('routezips', function (Blueprint $table) {
            $table->id();
            $table->integer('route_id')->comment('routes.id');
            $table->string('name');
            $table->string('zip_code');
            $table->tinyInteger('status')->default(1)->comment('1-Active,2-Inactive,3-Deleted,4-Permanent Deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routezips');
    }
};
