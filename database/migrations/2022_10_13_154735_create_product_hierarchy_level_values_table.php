<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductHierarchyLevelValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_hierarchy_level_values', function (Blueprint $table) {
            $table->id();
            $table->string('company_code')->nullable('');
            $table->string('level_name')->nullable('');
            $table->string('level_value_code')->nullable('');
            $table->string('level_value_name')->nullable('');
            $table->string('reporting_level_name')->nullable('');
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
        Schema::dropIfExists('product_hierarchy_level_values');
    }
}
