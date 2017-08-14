<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRouteTracesStartEnd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routetraces', function (Blueprint $p_table) {
            $p_table->float("start_lat")->nullable();
            $p_table->float("start_lon")->nullable();
            $p_table->float("end_lat")->nullable();
            $p_table->float("end_lon")->nullable();
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
            $p_table->dropColumn("start_lat");
            $p_table->dropColumn("start_lon");
            $p_table->dropColumn("end_lat");
            $p_table->dropColumn("end_lon");
        });
    }
}
