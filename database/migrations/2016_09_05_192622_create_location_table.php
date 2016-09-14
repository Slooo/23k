<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location', function (Blueprint $table) {
            $table->increments('location_id');
            $table->string('location_name')->nullable();
            $table->integer('res_id')->default(0);
            $table->integer('location_contractor_id')->default(0)
            $table->text('location_comment');
            $table->integer('fiz18')->default(0);
            $table->integer('report_ppo')->unsigned();
            $table->integer('schedule_plan')->unsigned();
            $table->integer('trp')->unsigned();
            $table->integer('estimate')->unsigned();
            $table->integer('kc2')->unsigned();
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
        Schema::drop('location');
    }
}