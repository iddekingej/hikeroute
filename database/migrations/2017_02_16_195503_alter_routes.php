<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRoutes extends Migration
{
    /**
     * Add location to route
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $p_table) {
            $p_table->string("location")->nullable();
        });
    }

    /**
     * Drop location column
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function (Blueprint $p_table) {
            $p_table->dropColumn("location");
        });
    }
}
