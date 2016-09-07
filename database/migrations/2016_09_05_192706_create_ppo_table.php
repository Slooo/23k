<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePpoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppo', function (Blueprint $table) {
            $table->increments('ppo_id');
            $table->integer('ppo_location_id')->default(0);
            $table->integer('ppo_object_id')->default(0);
            $table->integer('ppo_contractor_id')->default(0);
            $table->integer('ppo_res_id')->default(0);
            $table->integer('ppo_tp_id')->default(0);
            $table->string('ppo_street')->nullable();
            $table->string('ppo_house')->nullable();
            $table->string('ppo_kv')->nullable();
            $table->string('ppo_fio')->nullable();
            $table->string('ppo_tp')->nullable();
            $table->string('ppo_fider')->nullable();
            $table->string('ppo_highway_type')->nullable();
            $table->string('ppo_opora')->nullable();
            $table->string('ppo_gps')->nullable();
            $table->string('ppo_in_type')->nullable();
            $table->string('ppo_length')->nullable();
            $table->string('ppo_smr')->nullable();
            $table->string('ppo_faza')->nullable();
            $table->string('ppo_counter_num')->nullable();
            $table->string('ppo_counter_type')->nullable();
            $table->string('ppo_year_counter')->nullable();
            $table->string('ppo_place_install')->nullable();
            $table->string('ppo_vvod')->nullable();
            $table->string('ppo_comment')->nullable();
            $table->integer('ppo_valid')->default(0);
            $table->string('ppo_customer_type')->nullable();
            $table->string('ppo_opora_place')->nullable();
            $table->string('ppo_opora_place_montaj')->nullable();
            $table->string('trp')->nullable();
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
        Schema::drop('ppo');
    }
}