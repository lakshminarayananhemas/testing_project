<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGSTStateMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_s_t__state__masters', function (Blueprint $table) {
            $table->id();
            $table->string('gst_state_Code')->nullable('');
            $table->string('gst_state_name')->nullable('');
            $table->string('is_union_territory')->nullable('');
            $table->string('is_gst_enabled')->nullable('');
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
        Schema::dropIfExists('g_s_t__state__masters');
    }
}
