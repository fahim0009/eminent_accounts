<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('mofa_histories', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
    
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('cascade');
    
            $table->foreignId('mofa_trade')->nullable()->constrained('code_masters')->onDelete('set null');
            $table->foreignId('rlid')->nullable()->constrained('code_masters')->onDelete('set null');
    
            $table->longText('note')->nullable();
            $table->tinyInteger('status')->default(0);
    
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
    
            $table->timestamps();
        });
    }
    
};
