<?php 
declare(strict_types=1);
namespace App\Vc\Base;

use XMLView\Engine\Data\DataLayer;
use XMLView\Engine\Data\DataStore;
use XMLView\Engine\Data\MapData;

class PageDataLayer implements DataLayer
{
    function processData(DataStore $p_parent):DataStore
    {
        $l_map=new MapData($p_parent);
        $l_map->setValue("islogin",\Auth::user()?true:false);
        if(\Auth::user()){
            $l_map->setValue("username",\Auth::user()->name);
            $l_map->setValue("isadmin",\Auth::user()->isAdmin());
        } else {
            $l_map->setValue("username","");
            $l_map->setValue("isadmin",false);
        }
        return $l_map;
    }
}