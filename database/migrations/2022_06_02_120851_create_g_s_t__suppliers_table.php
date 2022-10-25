<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGSTSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_s_t__suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('company_code')->nullable('');
            $table->string('supplier_code')->nullable('');
            $table->string('supplier_name')->nullable('');
            $table->string('supplier_state')->nullable('');
            $table->string('gst_state_code')->nullable('');
            $table->string('supplier_gst_in')->nullable('');
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
        Schema::dropIfExists('g_s_t__suppliers');
    }
}
