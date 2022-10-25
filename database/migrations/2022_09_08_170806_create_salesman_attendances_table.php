<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesmanAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesman_attendances', function (Blueprint $table) {
            $table->id();
            $table->string('auto_id')->unique();
            $table->string('salesman_code');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->date('date')->nullable();
            $table->string('attendance_type');
            $table->string('reason');
            $table->string('remark');
            $table->time('total_login_hours')->nullable();
            $table->time('total_market_hours')->nullable();

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
        Schema::dropIfExists('salesman_attendances');
    }
}
