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
        Schema::create('kafela_client_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kafela_client_id')->unsigned()->nullable();
            $table->foreign('kafela_client_id')->references('id')->on('kafela_clients')->onDelete('cascade');
            $table->double('salary',10,2)->default(0);
            $table->string('description')->nullable();
            $table->string('job_title')->nullable();
            $table->string('job_company')->nullable();
            $table->string('joining_date')->nullable();
            $table->string('closing_date')->nullable();
            $table->string('aqama_image')->nullable();
            $table->string('aqama_exp_date')->nullable();
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
        Schema::dropIfExists('kafela_client_histories');
    }
};
