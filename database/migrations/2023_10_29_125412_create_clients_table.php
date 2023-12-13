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
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->bigInteger('account_id')->unsigned()->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->double('package_cost',10,2)->default(0);
            $table->string('passport_rcv_date')->nullable();
            $table->double('due_amount',10,2)->default(0);
            $table->double('total_rcv',10,2)->default(0);
            $table->double('refund',10,2)->default(0);
            $table->string('description')->nullable();
            $table->bigInteger('business_partner_id')->unsigned()->nullable();
            $table->foreign('business_partner_id')->references('id')->on('business_partners')->onDelete('cascade');
            $table->string('b2b_contact')->nullable();
            $table->double('b2b_payment',10,2)->nullable();
            $table->string('job_company')->nullable();
            $table->string('joining_date')->nullable();
            $table->double('salary',10,2)->nullable();
            $table->string('flight_date')->nullable();
            $table->string('visa_exp_date')->nullable();
            $table->boolean('processing')->default(1);
            $table->boolean('complete')->default(0);
            $table->boolean('decline')->default(0);
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
        Schema::dropIfExists('clients');
    }
};
