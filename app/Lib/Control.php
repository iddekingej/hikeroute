<?php
namespace App\Lib;

class Control{
	
	static function addressServiceEnabled()
	{
		if(\Config::get("hr.useAddressService")){
			if(\App::enviroment("test")){
				return \Config::get("hr.addressServiceOnTest");
			}
			return true;
		} 
		return false;
	}
}
