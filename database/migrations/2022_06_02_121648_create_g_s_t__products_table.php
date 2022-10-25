<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGSTProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_s_t__products', function (Blueprint $table) {
            $table->id();
            $table->string('company_code')->nullable('');
            $table->string('product_code')->nullable('');
            $table->string('product_name')->nullable('');
            $table->string('hsn_code')->nullable('');
            $table->string('hsn_name')->nullable('');
            $table->string('gst_product_type')->nullable('');
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
        Schema::dropIfExists('g_s_t__products');
    }
}
