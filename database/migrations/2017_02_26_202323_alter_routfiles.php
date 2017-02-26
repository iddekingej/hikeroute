<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRoutfiles extends Migration
{
    /**
     * Run the migrations.
     * Add "startdate" to table=>start of recording route
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routefiles', function (Blueprint $p_table) {
            $p_table->date("startdate")->nullable();
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
        	$p_table->dropColumn("startdate");
        });
    }
}
