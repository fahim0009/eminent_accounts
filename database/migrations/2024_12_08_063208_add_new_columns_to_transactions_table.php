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
        Schema::table('transactions', function (Blueprint $table) {

            $table->bigInteger('okala_id')->unsigned()->nullable()->after('tran_type');
            $table->foreign('okala_id')->references('id')->on('okalas')->onDelete('cascade');
            
            $table->bigInteger('okala_detail_id')->unsigned()->nullable()->after('tran_type');
            $table->foreign('okala_detail_id')->references('id')->on('okala_details')->onDelete('cascade');

            $table->bigInteger('okala_sale_id')->unsigned()->nullable()->after('tran_type');
            $table->foreign('okala_sale_id')->references('id')->on('okala_sales')->onDelete('cascade');

            $table->bigInteger('vendor_id')->unsigned()->nullable()->after('tran_type');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->double('riyalamount',10,2)->default(0)->after('tran_type');
            $table->string('document',191)->nullable()->after('note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
