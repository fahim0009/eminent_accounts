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
        Schema::create('okala_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('number')->nullable();
            $table->string('code')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('visaid')->nullable();
            $table->integer('sponsorid')->nullable();
            $table->double('bdt_amount',10,2)->default(0);
            $table->double('riyal_amount',10,2)->default(0);
            $table->double('total_riyal',10,2)->default(0);
            $table->double('total_bdt',10,2)->default(0);
            $table->boolean('purchase_type')->default(0);
            $table->string('trade')->nullable();
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
        Schema::dropIfExists('okalas');
    }
};
