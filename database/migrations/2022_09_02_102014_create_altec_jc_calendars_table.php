<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAltecJcCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('altec_jc_calendars', function (Blueprint $table) {
            $table->id();
            $table->string('fin_year')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('jc')->nullable();
            $table->string('jc_week')->nullable();
            $table->string('cal_week')->nullable();
            $table->string('jc_week_num')->nullable();
            $table->string('qtr')->nullable();
            $table->string('hy')->nullable();
            $table->string('jc_num')->nullable();
            $table->string('division')->nullable();
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
        Schema::dropIfExists('altec_jc_calendars');
    }
}
