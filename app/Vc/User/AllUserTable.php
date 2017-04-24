<?php 
declare(strict_types=1);
namespace App\Vc\User;

use App\Vc\Lib\TableVC;

class AllUserTable extends TableVC
{
    function __construct()
    {
        parent::__construct(\App\Models\User::orderBy("name")->get());
        $this->title=__("All users");
        $this->addConfig([
            "del"=>["type"=>"@iconlinkconfirm","confirmmsg"=>__("Delete this user?"),"icon"=>\App\Lib\Icons::DELETE,"title"=>""]
           ,"email"=>["type"=>"@link","title"=>"email"]
           ,"nick"=>["type"=>"@text","title"=>"nick"]
           ,"firstname"=>["type"=>"@text","title"=>"firstname"]
           ,"lastname"=>["type"=>"@text","title"=>"lastname"]         
           ]
        );
    }
    
    function getData($p_user)
    {
        return ["del"=>route("admin.users.delete",["id"=>$p_user->id])
            ,"email"=>[route("admin.users.edit",["id"=>$p_user->id]),$p_user->email]
            ,"nick"=>$p_user->name
            ,"firstname"=>$p_user->firstname
            ,"lastname"=>$p_user->lastname
          ];
    }
}