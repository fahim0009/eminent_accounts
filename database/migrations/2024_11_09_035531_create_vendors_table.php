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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            /* Users: 0=>User, 1=>Admin, 2=>Manager */
            $table->string('phone')->nullable();
            $table->longText('address')->nullable();
            $table->string('nid')->nullable();
            $table->string('nid_image')->nullable();
            $table->string('house')->nullable();
            $table->string('street')->nullable();
            $table->string('town')->nullable();
            $table->string('postcode')->nullable();
            $table->string('country')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('vendors');
    }
};
