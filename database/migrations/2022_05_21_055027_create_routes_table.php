<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('distributor_code')->nullable('');
            $table->string('distributor_branch_code')->nullable('');
            $table->string('route_code')->nullable('');
            $table->string('route_name')->nullable('');
            $table->string('status')->nullable('');
            $table->string('van_route_status')->nullable('');
            $table->string('population')->nullable('');
            $table->string('distance')->nullable('');
            $table->string('route_type')->nullable('');
            $table->string('city')->nullable('');
            $table->string('country_status')->nullable('');
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
        Schema::dropIfExists('routes');
    }
}
