<?php
use Illuminate\Database\Migrations\Migration;

class InsertRightsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table("rights")->insert([
            "description" => "Administrate site",
            "tag" => "admin"
        ]);
        DB::table("rights")->insert([
            "description" => "Post routes",
            "tag" => "post"
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
