<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('auto_id');
            $table->string('company');
            $table->string('gst_state_name');
            $table->string('supplier_code');
            $table->string('supplier_name');
            $table->string('s_address_1');
            $table->string('s_address_2');
            $table->string('s_address_3');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('postal_code');
            $table->string('geo_hierarchy_level');
            $table->string('geo_hierarchy_value');
            $table->string('phone_no');
            $table->string('contact_person');
            $table->string('s_emailid');
            $table->string('tin_no');
            $table->string('pin_no');
            $table->string('created_by');
            $table->string('modified_by');

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
        Schema::dropIfExists('suppliers');
    }
}
