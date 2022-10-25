<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_billings', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->string('distributor_code')->nullable();
            $table->string('salesman_code')->nullable();
            $table->string('route_code')->nullable();
            $table->string('customer_code')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('cash_dist_amt')->nullable();
            $table->string('cash_dist_percent')->nullable();
            $table->string('scheme_dist_amt')->nullable();
            $table->string('total_invoice_qty')->nullable();
            $table->string('credit_note_adjustment')->nullable();
            $table->string('debit_note_adjustment')->nullable();
            $table->string('gross_amount')->nullable();
            $table->string('total_addition')->nullable();
            $table->string('total_deduction')->nullable();
            $table->string('net_amount')->nullable();
            $table->date('order_date');
            $table->date('order_status');
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
        Schema::dropIfExists('order_billings');
    }
}
