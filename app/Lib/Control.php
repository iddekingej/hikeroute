<?php
namespace App\Lib;

class Control{
	
	static function addressServiceEnabled():bool
	{
		if(\Config::get("hr.useAddressService")){
			if(\App::runningUnitTests()){
				return \Config::get("hr.addressServiceOnTest");
			}
			return true;
		} 
		return false;
	}
}
