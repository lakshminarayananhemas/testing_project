<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesmanJcRouteMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesman_jc_route_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('distributor_code');
            $table->string('customer_code');
            $table->string('salesman_code');
            $table->string('route_code');
            $table->string('jc_month');
            $table->string('frequency');
            $table->string('daily')->nullable();
            $table->string('weekly')->nullable();
            $table->date('monthly')->nullable();
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
        Schema::dropIfExists('salesman_jc_route_mappings');
    }
}
