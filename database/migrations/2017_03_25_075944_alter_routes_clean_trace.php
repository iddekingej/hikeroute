<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRoutesCleanTrace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $p_table) {
            $p_table->dropColumn("minlat");
            $p_table->dropColumn("maxlat");
            $p_table->dropColumn("minlon");
            $p_table->dropColumn("maxlon");
            $p_table->dropColumn("distance");
            $p_table->dropForeign("routes_id_location_foreign");
            $p_table->dropColumn("id_location");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function (Blueprint $p_table) {
			$p_table->float("minlat")->nullable();
			$p_table->float("maxlat")->nullable();
			$p_table->float("minlon")->nullable();
			$p_table->float("maxlon")->nullable();
			$p_table->float("distance")->nullable();
			$p_table->unsignedInteger("id_location")->index()->nullable();
			$p_table->foreign("id_location")->references("id")->on("locations");
        });
    }
}
