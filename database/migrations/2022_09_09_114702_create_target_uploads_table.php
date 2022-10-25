<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code')->nullable('');
            $table->string('jc_period')->nullable('');
            $table->string('target_amount')->nullable('');
            $table->string('role_type')->nullable('');
            $table->string('created_by')->nullable('');
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
        Schema::dropIfExists('target_uploads');
    }
}
