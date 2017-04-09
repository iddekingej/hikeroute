<?php
namespace App\Lib;

class Control
{

    static function addressServiceEnabled(): bool
    {
        if (\Config::get("hr.useAddressService")) {
            if (\App::runningUnitTests()) {
                return \Config::get("hr.addressServiceOnTest");
            }
            return true;
        }
        return false;
    }

    static function locationServiceType()
    {
        return \Config::get("hr.locationServiceType");
    }

    static function locationServiceConfig()
    {
        $l_data = \Config::get("hr.locationServices");
        return $l_data[static::locationServiceType()];
    }
}
