<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor', function (Blueprint $table) {
            $table->increments('contractor_id');
            $table->string('contractor_name', 100)->nullable();
            $table->string('contractor_fio', 100)->nullable();
            $table->string('contractor_tel', 100)->nullable();
            $table->string('contractor_email', 100)->nullable();
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
        Schema::drop('contractor');
    }
}
