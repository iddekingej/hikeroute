<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRouteTrace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $p_table) {
           $p_table->unsignedInteger("id_routetrace")->nullable()->index();
           $p_table->foreign("id_routetrace")->references("id")->on("routetraces");
           $p_table->dropForeign("routes_id_routefile_foreign");
           $p_table->dropColumn("id_routefile");
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
        	$p_table->dropColumn("id_routetrace");
        	$p_table->unsignedInteger("id_routefile")->index();
        	$p_table->foreign("id_routefile")->references("id")->on("routefiles");
        });
    }
}
