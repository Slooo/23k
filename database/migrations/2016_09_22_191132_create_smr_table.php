<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smr', function (Blueprint $table) {
            $table->increments('smr_id');
            $table->integer('smr_contractor_id')->nullable();
            $table->integer('smr_location_id')->nullable();
            $table->string('smr_type_equipment')->nullable();
            $table->integer('smr_quantity')->default(0);
            $table->timestamp('smr_published_at')->nullable();
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
        Schema::drop('smr');
    }
}
