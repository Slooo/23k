<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res', function (Blueprint $table) {
            $table->increments('res_id');
            $table->string('pes')->nullable();
            $table->string('res_name')->nullable();
            $table->string('pes_name')->nullable();
            $table->integer('res_contractor_id')->default(0);
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
        Schema::drop('res');
    }
}