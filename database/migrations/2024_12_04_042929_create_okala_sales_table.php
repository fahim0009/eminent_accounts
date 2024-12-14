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
        Schema::create('okala_sales', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->bigInteger('okala_purchase_id')->unsigned()->nullable();
            $table->foreign('okala_purchase_id')->references('id')->on('okala_purchases')->onDelete('cascade');
            $table->string('number')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('r_l_detail_id')->unsigned()->nullable();
            $table->foreign('r_l_detail_id')->references('id')->on('code_master')->onDelete('cascade');
            $table->integer('visaid')->nullable();
            $table->integer('sponsor_id')->nullable();
            $table->string('trade')->nullable();
            $table->double('bdt_amount', 10,2)->nullable();
            $table->double('riyal_amount', 10,2)->nullable();
            $table->string('action')->nullable();
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
        Schema::dropIfExists('okala_sales');
    }
};
