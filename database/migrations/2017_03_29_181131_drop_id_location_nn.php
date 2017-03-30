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
		$p_table->dropForeign("routetraces_id_location_foreign");
	});
	Schema::table('routetraces', function (Blueprint $p_table) {
            $p_table->unsignedInteger("id_location")->nullable(true)->change();
            $p_table->foreign("id_location")->references("id")->on("locations");
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
        	$p_table->dropForeign("routetraces_id_location_foreign");
        });
        Schema::table('routetraces', function (Blueprint $p_table) {
        	$p_table->unsignedInteger("id_location")->nullable(false)->change();
        	$p_table->foreign("id_location")->references("id")->on("locations");
        });
    }
}
