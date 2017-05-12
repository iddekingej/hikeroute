<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RouteimageSummary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('route_images', function (Blueprint $p_table) {
            $p_table->integer("onsummary")->default(0);
        });
        DB::statement('ALTER TABLE route_images ADD CONSTRAINT chk_routeimage_1 CHECK (onsummary in (0,1));');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('route_images', function (Blueprint $p_table) {
            $p_table->dropColumn("onsummary");
        });
    }
}
