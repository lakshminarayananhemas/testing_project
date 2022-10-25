<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('at_orders', function (Blueprint $table) {
            $table->id();
            $table->string('orderId')->unique();
            $table->string('customerCode');
            $table->string('distributorCode');
            $table->string('signature');
            $table->string('totalAmount');
            $table->string('taxAmount');
            $table->string('discount');
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
        Schema::dropIfExists('at_orders');
    }
}
