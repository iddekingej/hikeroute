<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routefiles', function (Blueprint $table) {
            $table->increments('id');
            $table->text("gpxdata");
            $table->timestamps();
        });
        
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("id_user")->index();
            $table->foreign("id_user")
                ->references("id")
                ->on("users");
            $table->unsignedInteger("id_routefile")->index();
            $table->foreign("id_routefile")
                ->references("id")
                ->on("routefiles");
            $table->string("title", 255);
            $table->text("comment")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routes');
        Schema::dropIfExists("routefiles");
    }
}
