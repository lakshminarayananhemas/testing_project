<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGSTDistributorTaxStatesMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_s_t__distributor__tax__states__mappings', function (Blueprint $table) {
            $table->id();
            $table->string('company_code')->nullable('');
            $table->string('distributor_code')->nullable('');
            $table->string('to_state_code')->nullable('');
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
        Schema::dropIfExists('g_s_t__distributor__tax__states__mappings');
    }
}
