<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Right;
use App\Models\UserRight;
use App\Models\RouteTableCollection;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

/**
 * Remove all routefiles which doesn't have a record in the route table
 */
Artisan::command("cleangpx",function(){
	\App\Models\RouteFile::cleanGPX();
})->describe("Clean all dangeling gpx files");

/**
 * Recalc distance and area 
 */

Artisan::command("recalcallgpx",function(){
	RouteTableCollection::recalcAllGpx();
})->describe("Recalculate all summary information about gpx files");

/**
 * Create an admin account with a name or email
 */

Artisan::command("makeadmin{name}{email}",function($name,$email){
	
	if(!User::where("name",$name)->get()->isEmpty()){
		echo "Nick name already exists\n";
	}else if(!User::where("email",$email)->get()->isEmpty()){
		echo "Email already exists\n";
	} else {
		$l_password=sha1(mt_rand(0,100000)."-".mt_rand(0,100000)."-".mt_rand(0,100000)."-".mt_rand(0,100000));
		$l_user=User::create(["name"=>$name,"email"=>$email,"firstname"=>"x","lastname"=>"y","password"=>bcrypt($l_password)]);
		echo "Password = $l_password \n";
		foreach(Right::all() as $l_right) UserRight::addUserRight($l_user,$l_right);
	}
})->describe("Create admin user");
