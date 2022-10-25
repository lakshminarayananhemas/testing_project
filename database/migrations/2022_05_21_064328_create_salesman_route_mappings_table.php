<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesmanRouteMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesman_route_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('distributor_code')->nullable('');
            $table->string('distributor_branch_code')->nullable('');
            $table->string('salesman_code')->nullable('');
            $table->string('route_code')->nullable('');
            $table->string('status')->nullable('');
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
        Schema::dropIfExists('salesman_route_mappings');
    }
}
