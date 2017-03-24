<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRoutefile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routefiles', function (Blueprint $p_table) {
        	$p_table->unsignedInteger("id_user")->nullable()->index();
        	$p_table->foreign("id_user")->references("id")->on("users");
        	 
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
        	$p_table->dropForeign("routefiles_id_user_foreign");
			$p_table->dropColumn("id_user");
        });
    }
}
