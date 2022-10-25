<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('auto_id')->unique();
            $table->string('phll');
            $table->string('product_code');
            $table->string('product_name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('uom')->nullable();
            $table->string('conversion_factor')->nullable();
            $table->string('ean_code')->nullable();
            $table->string('net_wgt')->nullable();
            $table->string('weight_type')->nullable();
            $table->string('shelf_life')->nullable();
            $table->string('product_type');
            $table->string('drug_product')->nullable();
            $table->string('status')->nullable();
            $table->string('serial_no_exist')->nullable();
            $table->string('second_serial_no_applicable')->nullable();
            $table->string('second_serial_no_mandatory')->nullable();
            $table->string('ghl')->nullable();
            $table->string('hsn_code')->nullable();
            $table->string('hsn_name')->nullable();
            $table->string('gst_p_type')->nullable();
            $table->string('brandcategory')->nullable();
            $table->string('brandpack')->nullable();
            $table->string('division')->nullable();

            //app aug 22 
            $table->double('mrp')->nullable();
            $table->double('ptr')->nullable();
            $table->bigInteger('available_quantity')->nullable();
            $table->string('sku_type')->nullable();
            $table->double('sih')->nullable();
            $table->double('soq')->nullable();
            $table->double('mss')->nullable();
            //app aug 22 end

            $table->string('created_by');
            $table->string('modified_by');
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
        Schema::dropIfExists('products');
    }
}
