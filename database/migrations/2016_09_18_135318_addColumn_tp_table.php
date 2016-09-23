<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tp', function ($table) {
            $table->integer('tp_pooporka_res')->default(0)->after('tp_poporka');
            $table->integer('uniquesmr')->default(1)->after('tp_pooporka_res');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('location', function ($table) {
            $table->dropColumn(['tp_pooporka_res', 'uniquesmr']);
        });
    }
}