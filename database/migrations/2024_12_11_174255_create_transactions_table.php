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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('tran_id')->nullable();
            $table->bigInteger('account_id')->unsigned()->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->string('ref')->nullable();
            $table->longText('note')->nullable();
            $table->string('document',191)->nullable();
            $table->string('tran_type')->nullable();
            $table->bigInteger('okala_purchase_id')->unsigned()->nullable();
            $table->foreign('okala_purchase_id')->references('id')->on('okala_purchases')->onDelete('cascade');            
            $table->bigInteger('okala_sale_id')->unsigned()->nullable();
            $table->foreign('okala_sale_id')->references('id')->on('okala_sales')->onDelete('cascade');
            $table->double('foreign_amount',10,2)->default(0);
            $table->string('foreign_amount_type')->default('riyal');
            $table->double('bdt_amount',10,2)->default(0);
            $table->string('payment_type')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
