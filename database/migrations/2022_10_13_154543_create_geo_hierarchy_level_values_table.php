<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeoHierarchyLevelValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_hierarchy_level_values', function (Blueprint $table) {
            $table->id();
            $table->string('company_code')->nullable('');
            $table->string('level_name')->nullable('');
            $table->string('level_code')->nullable('');
            $table->string('company_value')->nullable('');
            $table->string('reporting_to')->nullable('');
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
        Schema::dropIfExists('geo_hierarchy_level_values');
    }
}
