<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryboyRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryboy_routes', function (Blueprint $table) {
            $table->id();
            $table->string('distributor_code')->nullable('');
            $table->string('distributor_branch_code')->nullable('');
            $table->string('deliveryboy_code')->nullable('');
            $table->string('route_code')->nullable('');
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
        Schema::dropIfExists('deliveryboy_routes');
    }
}
