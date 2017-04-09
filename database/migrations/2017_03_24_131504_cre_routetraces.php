<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreRoutetraces extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routetraces', function (Blueprint $p_table) {
            $p_table->increments('id');
            $p_table->unsignedInteger("id_user")->index();
            $p_table->foreign("id_user")
                ->references("id")
                ->on("users");
            $p_table->unsignedInteger("id_routefile")->index();
            $p_table->foreign("id_routefile")
                ->references("id")
                ->on("routefiles");
            $p_table->unsignedInteger("id_location")->index();
            $p_table->foreign("id_location")
                ->references("id")
                ->on("locations");
            $p_table->date("startdate")->nullable();
            $p_table->float("minlat")->nullable();
            $p_table->float("maxlat")->nullable();
            $p_table->float("minlon")->nullable();
            $p_table->float("maxlon")->nullable();
            $p_table->float("distance")->nullable();
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
        Schema::dropIfExists('routetraces');
    }
}
