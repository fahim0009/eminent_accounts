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
        Schema::create('okala_sale_details', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->bigInteger('okala_sale_id')->unsigned()->nullable();
            $table->foreign('okala_sale_id')->references('id')->on('okala_sales')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('r_l_detail_id')->unsigned()->nullable();
            $table->foreign('r_l_detail_id')->references('id')->on('code_masters')->onDelete('cascade');
            $table->integer('visaid')->nullable();
            $table->integer('sponsorid')->nullable();
            $table->string('trade')->nullable();
            $table->double('bdt_amount', 10,2)->nullable();
            $table->double('riyal_amount', 10,2)->nullable();
            $table->string('action')->nullable();
            $table->string('iqama')->nullable();
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
        Schema::dropIfExists('okala_sale_details');
    }
};
