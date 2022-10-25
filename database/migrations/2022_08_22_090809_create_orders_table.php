<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('salesman_code')->nullable();
            $table->string('customer_code')->nullable();
            $table->string('distributor_code')->nullable();
            $table->string('order_id')->unique();
            $table->string('signature')->nullable();
            $table->double('total_amount')->nullable();
            $table->double('tax_amount')->nullable();
            $table->double('discount')->nullable();
            $table->string('order_bill_id')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
