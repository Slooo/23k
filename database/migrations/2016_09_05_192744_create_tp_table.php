<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tp', function (Blueprint $table) {
            $table->increments('tp_id');
            $table->integer('tp_num')->default(0);
            $table->integer('not_access')->default(0);
            $table->string('ascue')->nullable();
            $table->string('ascue_tech')->nullable();
            $table->integer('customer_ascue')->default(0);
            $table->text('tp_comment');
            $table->integer('tp_location_id')->default(0);
            $table->integer('tp_otchetPPO')->default(0);
            $table->integer('tp_photo')->default(0);
            $table->integer('tp_otchet')->default(0);
            $table->integer('tp_poporka')->default(0);
            $table->integer('tp_1line')->default(0);
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
        Schema::drop('tp');
    }
}