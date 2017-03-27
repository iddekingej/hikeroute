<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRoutefilesGpxdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routefiles', function (Blueprint $p_table) {
        	$p_table->longtext("gpxdata2")->nullable();
           //	$p_table->dropColumn("gpxdata");
        //	$p_table->renameColumn("gpxdata2", "gpxdata");
        });
        	
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
