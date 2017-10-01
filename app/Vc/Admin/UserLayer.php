<?php 
declare(strict_types=1);
namespace App\Vc\Admin;

use XMLView\Engine\Data\DataLayer;
use XMLView\Engine\Data\MapData;
use XMLView\Engine\Data\DataStore;
use App\Models\RightTableCollection;
use XMLView\Base\Base;

class UserLayer extends Base implements DataLayer 
{
    function processData(DataStore $p_parent):DataStore
    {
        $l_user=$p_parent->getValue("user");
        $l_store=new MapData($p_parent);
        $l_store->setValue("id",$l_user?$l_user->id:null);
        $l_store->setValue("cmd",$l_user?"edit":"add");
        $l_store->setValue("name",$l_user?$l_user->name:"");
        $l_store->setValue("email",$l_user?$l_user->email:"");
        $l_store->setValue("firstname",$l_user?$l_user->firstname:"");
        $l_store->setValue("lastname",$l_user?$l_user->lastname:"");
        $l_store->setValue("enabled",$l_user?$l_user->enabled:false);
        $l_store->setValue("resetpassword",false);
        $l_store->setValue("password","");
        $l_store->setValue("passwordconf","");
        $l_store->setValue("new",$l_user?"false":"true");
        $l_rights=[];
        $l_allRights=RightTableCollection::all();
        foreach($l_allRights as $l_right){
            $l_rights[]=["id"=>$l_right->id,"label"=>$l_right->description,"right"=>$l_user?$l_user->checkHasRight($l_right->tag):true];
            
        }
        $l_store->setValue("rights",$l_rights);
        return $l_store;
    }
}