<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropIdLocationNn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routetraces', function (Blueprint $p_table) {
            $p_table->unsignedInteger("id_location")->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routetraces', function (Blueprint $p_table) {
        	$p_table->unsignedInteger("id_location")->nullable(false)->change();
        });
    }
}
