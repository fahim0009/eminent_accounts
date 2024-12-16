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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('clientid')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_name')->nullable();
            $table->string('passport_image')->nullable();
            $table->string('client_image')->nullable();
            $table->string('visa')->nullable();
            $table->string('manpower_image')->nullable();
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('code_masters')->onDelete('cascade');
            $table->double('package_cost',10,2)->default(0);
            $table->string('passport_rcv_date')->nullable();
            $table->double('refund',10,2)->default(0);
            $table->string('description')->nullable();
            $table->string('medical_exp_date')->nullable();
            $table->bigInteger('mofa_trade')->unsigned()->nullable();
            $table->string('job_company')->nullable();
            $table->string('joining_date')->nullable();
            $table->double('salary',10,2)->nullable();
            $table->string('flight_date')->nullable();
            $table->string('visa_exp_date')->nullable();
            $table->boolean('is_job')->nullable();
            $table->boolean('is_ticket')->nullable();
            $table->string('assign')->default(0);
            $table->string('status')->default(0);
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
        Schema::dropIfExists('clients');
    }
};
