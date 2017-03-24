<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create("locationtypes",function (Blueprint $p_table){
    		$p_table->increments("id");
    		$p_table->integer("sequence");
    		$p_table->unique("sequence");
    		$p_table->string("description",32)->index();
    	});
        Schema::create('locations', function (Blueprint $p_table) {
            $p_table->increments('id');
            $p_table->unsignedInteger("id_locationtype")->index();
            $p_table->foreign("id_locationtype")->references("id")->on("locationtypes");
            $p_table->unsignedInteger("id_parent")->nullable()->index();
            $p_table->foreign("id_parent")->references("id")->on("locations");
            $p_table->string("name",1024);
            $p_table->timestamps();
        });
        DB::table("locationtypes")->insert([
        		"sequence"=>0,
        		"description"=>"country"
        	]
        );
        DB::table("locationtypes")->insert([
        		"sequence"=>1,
        		"description"=>"state"
        ]
        );
        DB::table("locationtypes")->insert([
        		"sequence"=>2,
        		"description"=>"city"
        ]
        );
        DB::table("locationtypes")->insert([
        		"sequence"=>3,
        		"description"=>"suburb"
        ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
        Schema::dropIfExists("locationtypes");
    }
}
