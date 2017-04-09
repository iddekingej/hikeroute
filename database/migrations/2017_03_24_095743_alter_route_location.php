<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRouteLocation extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $p_table) {
            $p_table->unsignedInteger("id_location")
                ->nullable()
                ->index();
            $p_table->foreign("id_location")
                ->references("id")
                ->on("locations");
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
            $p_table->dropForeign("routes_id_location_foreign");
            $p_table->dropColumn("id_location");
        });
    }
}
