<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('distributors', function (Blueprint $table) {
            $table->id();
            $table->string('auto_id')->unique();
            $table->string('distributor_code');
            $table->string('distributor_name');
            $table->string('distributor_type');
            $table->string('parent_code');
            $table->string('supplier');
            $table->string('discount_based_on');
            $table->text('distributor_permission')->nullable();
            $table->string('status');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('postal_code');
            $table->string('phone_no');
            $table->string('email_id');
            $table->string('fssai_no');
            $table->string('drug_licence_no');
            $table->string('dl_expiry_date');
            $table->string('weekly_off');
            $table->string('channel_code');
            $table->string('category_type');
            $table->string('numofsalesmans');
            $table->string('salary_budget');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('geo_hierarchy_level');
            $table->string('geo_hierarchy_value');
            $table->string('sales_hierarchy_level');
            $table->string('lob');
            $table->string('sales_hierarchy_value');
            $table->string('gst_state_name');
            $table->string('pan_no');
            $table->string('gstin_number');
            $table->string('aadhar_no');
            $table->string('tcs_applicable');
            $table->string('gst_distributor');
            $table->string('tds_applicable');
            $table->string('password');
            
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
        Schema::dropIfExists('distributors');
    }
}
