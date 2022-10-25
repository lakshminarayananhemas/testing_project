<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesmanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesman', function (Blueprint $table) {
            $table->id();
            $table->string('distributor_code')->nullable('');
            $table->string('distributor_branch_code')->nullable('');
            $table->string('salesman_name')->nullable('');
            $table->string('email_id')->nullable('');
            $table->string('phone_no')->nullable('');
            $table->string('daily_allowance')->nullable('');
            $table->string('salary')->nullable('');
            $table->string('status')->nullable('');
            $table->string('salesman_code')->nullable('');
            $table->date('dob');
            $table->date('doj');
            $table->string('password')->nullable('');
            $table->string('salesman_type')->nullable('');
            $table->string('sm_unique_code')->nullable('');
            $table->string('third_party_empcode')->nullable('');
            $table->string('replacement_for')->nullable('');

            $table->string('attach_company')->nullable('');
            $table->string('sales_type')->nullable('');
            $table->string('godown_status')->nullable('');
            $table->string('aadhaar_no')->nullable('');
            $table->string('sfa_status')->nullable('');
            $table->string('device_no')->nullable('');
            $table->string('sfa_pass_status')->nullable('');
            $table->string('salesman_image')->nullable('');

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
        Schema::dropIfExists('salesmen');
    }
}
