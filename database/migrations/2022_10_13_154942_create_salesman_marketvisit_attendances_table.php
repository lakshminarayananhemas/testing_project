<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesmanMarketvisitAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesman_marketvisit_attendances', function (Blueprint $table) {
            $table->id();
            $table->string('auto_id')->unique();
            $table->string('sa_id');
            $table->string('salesman_code');
            $table->string('customer_code');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->time('current_market_hours')->nullable();
            $table->string('no_sale_reason');
            $table->date('date')->nullable();
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
        Schema::dropIfExists('salesman_marketvisit_attendances');
    }
}
