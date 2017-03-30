<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreTracelocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracelocations', function (Blueprint $p_table) {
            $p_table->increments('id');
            $p_table->unsignedInteger("id_location")->index();
            $p_table->foreign("id_location")->references("id")->on("locations");
            $p_table->unsignedInteger("id_routetrace")->index();
            $p_table->foreign("id_routetrace")->references("id")->on("routetraces");
            $p_table->unsignedInteger("position");
            $p_table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracelocations');
    }
}
