<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRoute extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $p_table) {
            $p_table->integer("publish")
                ->default(0)
                ->index();
        });
        DB::statement('ALTER TABLE routes add constraint chk_routes check(publish in(0,1))');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function (Blueprint $p_table) {
            $p_table->dropColumn("publish");
        });
    }
}
