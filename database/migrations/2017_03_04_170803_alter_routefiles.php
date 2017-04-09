<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRoutefiles extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $p_table) {
            $p_table->float("minlat")->nullable();
            $p_table->float("maxlat")->nullable();
            $p_table->float("minlon")->nullable();
            $p_table->float("maxlon")->nullable();
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
            $p_table->dropColumn("minlat");
            $p_table->dropColumn("maxlat");
            $p_table->dropColumn("minlon");
            $p_table->dropColumn("maxlon");
        });
    }
}
