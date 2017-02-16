<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRightsTable extends Migration
{
    /**
     * Run the migrations for rights and right_users tables
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('rights', function (Blueprint $p_table) {
        	$p_table->increments('id');
        	$p_table->string("description");
        	$p_table->string("tag",160)->unique();
        });
        Schema::create("user_rights",function(Blueprint $p_table){
        	$p_table->increments("id");
        	$p_table->unsignedInteger("id_user")->index();
        	$p_table->foreign("id_user")->references("id")->on("users");
        	$p_table->unsignedInteger("id_right")->index();
      		$p_table->foreign("id_right")->references("id")->on("rights");
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::dropIfExists("user_rights");
    	Schema::dropIfExists('rights');    	 
    }
}
