<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributorStockReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributor__stock_reports', function (Blueprint $table) {
            $table->id(); 
            $table->string('distributorcode')->nullable();
            $table->string('distributor_name')->nullable();
            $table->string('distributor_br_code')->nullable();
            $table->string('distributor_br_name')->nullable();
            $table->string('godown_name')->nullable();
            $table->string('product_code')->nullable();
            $table->string('product_description')->nullable();
            $table->string('batch')->nullable();
            $table->date('expiry_date')->nullable();
            $table->double('mrp')->nullable(); 
            $table->string('purch_price_without')->nullable(); 	
            $table->bigInteger('saleable_stock')->nullable();	
            $table->bigInteger('unsaleable_stock')->nullable();	
            $table->bigInteger('offer_stock')->nullable();	
            $table->double('saleable_stock_value')->nullable();	
            $table->double('unsaleable_stock_value')->nullable();	
            $table->double('tot_stock_value')->nullable();

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
        Schema::dropIfExists('distributor__stock_reports');
    }
}
