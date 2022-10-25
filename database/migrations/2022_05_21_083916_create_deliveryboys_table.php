<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryboysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryboys', function (Blueprint $table) {
            $table->id();
            $table->string('distributor_code')->nullable('');
            $table->string('distributor_branch_code')->nullable('');
            $table->string('deliveryboy_code')->nullable('');
            $table->string('deliveryboy_name')->nullable('');
            $table->string('phone_no')->nullable('');
            $table->string('email_id')->nullable('');
            $table->string('daily_allowance')->nullable('');
            $table->string('salary')->nullable('');
            $table->string('status')->nullable('');
            $table->string('default_status')->nullable('');
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
        Schema::dropIfExists('deliveryboys');
    }
}
