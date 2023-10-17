<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('date')->nullable();
            $table->double('expense',10,2)->nullable();
            $table->double('income',10,2)->nullable();
            $table->double('others',10,2)->nullable();
            $table->string('category',255)->nullable();
            $table->longText('particular')->nullable();
            $table->double('amount',10,2)->nullable();
            $table->double('vat',10,2)->nullable();
            $table->double('net',10,2)->nullable();
            $table->bigInteger('photo_id')->unsigned()->nullable();
            $table->foreign('photo_id')->references('id')->on('photos')->onDelete('cascade');
            $table->string('image_link',255)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
