<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailerChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailer_channels', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('channel_code');
            $table->string('channel_name')->nullable();
            $table->string('sub_channel_code')->nullable();
            $table->string('sub_channel_name')->nullable();
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
        Schema::dropIfExists('retailer_channels');
    }
}
