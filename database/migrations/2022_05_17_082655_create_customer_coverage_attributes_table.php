<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerCoverageAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_coverage_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('auto_id')->default('');
            $table->string('cg_id')->default('');
            $table->string('ca_coverage_mode')->default('');
            $table->string('ca_coverage_frequency')->default('');
            $table->string('ca_sales_route')->default('');
            $table->string('ca_delivery_route')->default('');
            $table->string('ca_retailer_class')->default('');
            $table->string('ca_retailer_attribute_type')->default('');
            $table->string('ca_parent_child')->default('');
            $table->string('ca_attach_parent')->default('');
            $table->string('ca_key_account')->default('');
            $table->string('ca_ra_mapping')->default('');

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
        Schema::dropIfExists('customer_coverage_attributes');
    }
}
