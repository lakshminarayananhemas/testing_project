<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_generals', function (Blueprint $table) {
            $table->id();
            $table->string('auto_id');
            $table->string('cg_distributor_branch');
            $table->string('cg_type');
            $table->string('cg_customer_code');
            $table->string('cg_dist_cust_code');
            $table->string('cg_cmpny_cust_code');
            $table->string('cg_salesman_code');
            $table->string('cg_customer_name');
            $table->string('cg_address_1');
            $table->string('cg_address_2');
            $table->string('cg_address_3')->nullable();
            $table->string('cg_country');
            $table->string('cg_state');
            $table->string('cg_city');
            $table->string('cg_postal_code');
            $table->string('cg_phoneno');
            $table->string('cg_mobile');
            $table->string('cg_latitude')->nullable();
            $table->string('cg_longitude')->nullable();
            $table->string('cg_distance')->nullable();
            $table->string('cg_dob')->nullable();
            $table->string('cg_anniversary')->nullable();
            $table->string('cg_enrollment_date')->nullable();
            $table->string('cg_contact_person')->nullable();
            $table->string('cg_emailid');
            $table->string('cg_gst_state');
            $table->string('cg_retailer_type')->nullable();
            $table->string('cg_pan_type')->nullable();
            $table->string('cg_panno')->nullable();
            $table->string('cg_aadhaar_no')->nullable();
            $table->string('cg_gstin_number');
            $table->string('cg_tcs_applicable')->nullable();
            $table->string('cg_related_party')->nullable();
            $table->string('cg_composite')->nullable();
            $table->string('cg_tds_applicable')->nullable();
            $table->string('ca_customer_status')->nullable();
            $table->string('ca_approval_status')->nullable();

            // app
            $table->integer('otp')->nullable();
            $table->integer('otpStatus')->nullable();
            $table->string('cg_billType')->nullable();
            // end app
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();

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
        Schema::dropIfExists('customer_generals');
    }
}
