<?php 
declare(strict_types=1);
namespace App\Vc\User;

use App\Vc\Lib\TableVC;
/**
 * List of all users
  *
 */
class AllUserTable extends TableVC
{
    /**
     * Setup table column definition.
     * This table contains the email adres, nick name,firstname and lastname.
     * Also a icon to delete the user.
     */
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
/**
 * Create data row for table containing a delete button, email adres,nic, firstname and lastname
 * of every user.
 * 
 * {@inheritDoc}
 * @see \App\Vc\Lib\TableVC::getData()
 */    
    function getData($p_user)
    {
        return ["del"=>$p_user->canDelete()?route("admin.users.delete",["id"=>$p_user->id]):NULL
            ,"email"=>[route("admin.users.edit",["id"=>$p_user->id]),$p_user->email]
            ,"nick"=>$p_user->name
            ,"firstname"=>$p_user->firstname
            ,"lastname"=>$p_user->lastname
          ];
    }
}