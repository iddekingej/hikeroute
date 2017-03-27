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
        	$p_table->longtext("gpxdata")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routefiles', function (Blueprint $p_table) {
        	$p_table->text("gpxdata")->change();
        });
    }
}
