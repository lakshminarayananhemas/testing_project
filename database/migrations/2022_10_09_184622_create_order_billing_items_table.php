<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderBillingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_billing_items', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('product_code')->nullable();
            $table->string('product_name')->nullable();
            $table->string('batch')->nullable();
            $table->date('exp_date')->nullable();
            $table->string('order')->nullable();
            $table->string('order_qty')->nullable();
            $table->string('inv_qty')->nullable();
            $table->string('mrp')->nullable();
            $table->string('sell_rate')->nullable();
            $table->string('gross_amt')->nullable();
            $table->string('line_disc_amt')->nullable();
            $table->string('tax_amt')->nullable();
            $table->string('net_rate')->nullable();
            $table->string('net_amt')->nullable();

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
        Schema::dropIfExists('order_billing_items');
    }
}
