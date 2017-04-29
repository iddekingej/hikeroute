<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("images",function (Blueprint $p_table){
            $p_table->increments("id");
            $p_table->longText("image");
            $p_table->string("mimetype",255);
            $p_table->timestamps();
            
        });
        Schema::create('route_images', function (Blueprint $p_table) {
            $p_table->increments('id');
            $p_table->unsignedInteger("id_route")->index();
            $p_table->unsignedInteger("position");
            $p_table->foreign("id_route")->references("id")->on("routes");
            $p_table->unsignedInteger("id_image")->index();
            $p_table->foreign("id_image")->references("id")->on("images");
            $p_table->unsignedInteger("id_thumbnail")->index();
            $p_table->foreign("id_thumbnail")->references("id")->on("images");            
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
        Schema::dropIfExists("route_images");
        Schema::dropIfExists('images');
    }
}
