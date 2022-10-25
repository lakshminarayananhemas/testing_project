<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeningBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opening_balances', function (Blueprint $table) {
            $table->id();
            $table->string('distributor_code')->nullable('');
            $table->string('distributor_branch_code')->nullable('');
            $table->string('coa_code')->nullable('');
            $table->string('credit_amount')->nullable('');
            $table->string('debit_amount')->nullable('');
            $table->date('opening_balance_date')->nullable('');
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
        Schema::dropIfExists('opening_balances');
    }
}
