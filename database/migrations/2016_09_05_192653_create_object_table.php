<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object', function (Blueprint $table) {
            $table->increments('object_id');
            $table->integer('location_id')->nullable();
            $table->integer('contractor_id')->nullable();
            $table->integer('res')->nullable();
            $table->string('location_type')->nullable();
            $table->string('pc')->nullable();
            $table->string('fider')->nullable();
            $table->string('tp_type')->nullable();
            $table->string('tp')->nullable();
            $table->string('street')->nullable();
            $table->string('house')->nullable();
            $table->string('kv')->nullable();
            $table->string('customer')->nullable();
            $table->string('counter_num')->nullable();
            $table->string('counter_type')->nullable();
            $table->string('faza')->nullable();
            $table->string('tel')->nullable();
            $table->text('comment');
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
        Schema::drop('object');
    }
}