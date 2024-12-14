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
        Schema::create('okala_purchase_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('okala_purchase_id')->unsigned()->nullable();
            $table->foreign('okala_purchase_id')->references('id')->on('okala_purchases')->onDelete('cascade');
            $table->string('date')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('r_l_detail_id')->unsigned()->nullable();
            $table->foreign('r_l_detail_id')->references('id')->on('code_master')->onDelete('cascade');
            $table->integer('visa_id')->nullable();
            $table->integer('sponsor_id')->nullable();
            $table->string('assign_to')->nullable();
            $table->string('action')->nullable();
            $table->string('aqama')->nullable();
            $table->boolean('status')->default(0);
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('okala_details');
    }
};
