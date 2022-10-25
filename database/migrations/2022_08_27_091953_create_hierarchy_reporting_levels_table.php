<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHierarchyReportingLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hierarchy_reporting_levels', function (Blueprint $table) {
            $table->id();
            $table->string('auto_id')->nullable();
            $table->string('company_id')->nullable();
            $table->string('hierarchy_level_id')->nullable();
            $table->string('reporting_level_name')->nullable();

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
        Schema::dropIfExists('hierarchy_reporting_levels');
    }
}
