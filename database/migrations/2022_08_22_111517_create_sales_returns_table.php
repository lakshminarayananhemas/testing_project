<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_returns', function (Blueprint $table) {
            $table->id();
            $table->string('sales_return_id')->nullable();
            $table->string('reference')->nullable();
            $table->string('invoice')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('distributor_code')->nullable();
            $table->string('salesman_code')->nullable();
            $table->string('customer_code')->nullable();

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
        Schema::dropIfExists('sales_returns');
    }
}
