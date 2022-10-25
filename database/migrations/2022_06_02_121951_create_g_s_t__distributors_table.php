<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGSTDistributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_s_t__distributors', function (Blueprint $table) {
            $table->id();
            $table->string('company_code')->nullable();
            $table->string('distributor_code')->nullable();
            $table->string('distributor_name')->nullable();
            $table->string('gstin_number')->nullable();
            $table->string('gst_distr_type')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('gst_state_code')->nullable();
            $table->string('fssai_no')->nullable();
            $table->string('aadhar_no')->nullable();
            $table->string('tcs_applicable')->nullable();
            $table->string('tds_applicable')->nullable();
            $table->string('itr_filed')->nullable();
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
        Schema::dropIfExists('g_s_t__distributors');
    }
}
