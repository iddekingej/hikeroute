<?php 
declare(strict_types=1);
namespace App\Vc\User;



use XMLView\Widgets\Lists\Table;
use XMLView\Engine\Data\DataStore;
use XMLView\Engine\Data\DynamicStaticValue;
use App\Models\User;

/**
 * List of all users
  *
 */
class XMLAllUserTable extends Table
{
    /**
     * Setup table column definition.
     * This table contains the email adres, nick name,firstname and lastname.
     * Also a icon to delete the user.
     */
    function __construct()
    {
        parent::__construct();
        $this->data=new DynamicStaticValue(User::orderBy("name")->get());
        $this->setTitle(new DynamicStaticValue(__("All users")));
        $this->addConfig([
            "del"=>["type"=>"@iconlinkconfirm","confirmmsg"=>__("Delete this user?"),"icon"=>\App\Lib\Icons::DELETE,"title"=>""]
           ,"email"=>["type"=>"@link","title"=>__("email")]
           ,"nick"=>["type"=>"@text","title"=>__("nick")]
           ,"firstname"=>["type"=>"@text","title"=>__("firstname")]
           ,"lastname"=>["type"=>"@text","title"=>__("lastname")]
           ,"enabled"=>["type"=>"@text","title"=>__("Enabled")]
           ]
        );
    }
/**
 * Create data row for table containing a delete button, email adres,nic, firstname and lastname
 * of every user.
 * 
 * {@inheritDoc}
 * @see \App\Vc\Lib\Table::getData()
 */    
    function getData($p_user,DataStore $p_store)
    {
        return ["del"=>$p_user->canDelete()?route("admin.users.delete",["id"=>$p_user->id]):NULL
            ,"email"=>[route("admin.users.edit",["id"=>$p_user->id]),$p_user->email]
            ,"nick"=>$p_user->name
            ,"firstname"=>$p_user->firstname
            ,"lastname"=>$p_user->lastname
            ,"enabled"=>$p_user->enabled?"X":""
          ];
    }
}