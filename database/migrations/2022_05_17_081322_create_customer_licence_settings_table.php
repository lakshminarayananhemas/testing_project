<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerLicenceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_licence_settings', function (Blueprint $table) {
            $table->id();
            $table->string('auto_id')->default('');
            $table->string('cg_id')->default('');
            $table->string('ls_tin_no')->default('');
            $table->string('ls_pin_no')->default('');
            $table->string('ls_cst_no')->default('');
            $table->string('ls_drug_license_no1')->default('');
            $table->date('ls_lic_expiry_date');
            $table->string('ls_drug_license_no2')->default('');
            $table->date('ls_dl1_expiry_date');
            $table->string('ls_pest_license_no')->default('');
            $table->date('ls_dl2_expiry_date');
            $table->string('ls_fssai_no')->default('');
            $table->string('ls_credit_bill')->default('');
            $table->string('ls_credit_bill_status')->default('');
            $table->string('ls_credit_limit')->default('');
            $table->string('ls_credit_limit_status')->default('');
            $table->string('ls_credit_days')->default('');
            $table->string('ls_credit_days_status')->default('');
            $table->string('ls_cash_discount')->default('');
            $table->string('ls_limit_amount')->default('');
            $table->string('ls_cd_trigger_action')->default('');
            $table->string('ls_trigger_amount')->default('');
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
        Schema::dropIfExists('customer_licence_settings');
    }
}
