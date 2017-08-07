<?php 

namespace App\Vc\Admin;
use App\Vc\Lib\Form;
use Illuminate\Support\ViewErrorBag;
use App\Models\User;
use App\Models\RightTableCollection;

class UserForm extends Form
{
    private $user;
    private $allRights;
    function __construct($p_cmd,?User $p_user,ViewErrorBag $p_errors)
    {
        $this->user=$p_user;
        $this->url=Route("admin.users.save.$p_cmd");
        $this->cancelUrl=Route("admin.users");
        $this->title=__("Edit user");
        
        $this->data["password"]="";
        $this->data["passwordconf"]="";
        if($p_user){
            $this->data["name"]=$p_user->name;
            $this->data["firstname"]=$p_user->firstname;
            $this->data["lastname"]=$p_user->lastname;
            $this->data["resetpassword"]=false;
            $this->data["email"]=$p_user->email;
            $this->data["enabled"]=$p_user->enabled;
            $this->addHidden("id",$p_user->id);
            
        } else {
            $this->data["name"]="";
            $this->data["firstname"]="";
            $this->data["lastname"]="";
            $this->data["email"]="";
            $this->data["enabled"]="";
            $this->addHidden("id","");
        }
        $this->allRights=RightTableCollection::all();
        foreach($this->allRights as $l_right){
            $this->data["right_".$l_right->id]=false;
        }
        if($p_user){
            foreach($p_user->userRights as $l_ur){
                $this->data["right_".$l_ur->right->id]=true;
            }
        }
        parent::__construct($p_errors);
    }
    
    function setup()
    {
        
        $this->addElements([
            "name"=>["type"=>"@text","label"=>__("Nickname")]
            ,"firstname"=>["type"=>"@text","label"=>__("Firstname")]
            ,"lastname"=>["type"=>"@text","label"=>__("Lastname")]
            ,"email"=>["type"=>"@text","label"=>__("Email")]
            ,"enabled"=>["type"=>"@checkbox","label"=>__("Account is active")]
        ]);
        if($this->user){
            $this->addElement("resetpassword", ["type"=>"@checkbox","label"=>__("Reset password")]);
        }
        $this->addElements([
            "password"=>["type"=>"@password","label"=>__("Password"),"condition"=>"form.resetpassword.checked"]
            ,"passwordconf"=>["type"=>"@password","label"=>__("Password confirmation"),"condition"=>"form.resetpassword.checked"]
            ,"sec1"=>["type"=>"@section","title"=>__("Rights")]
        ]);
        
        foreach($this->allRights as $l_right){            
            $this->addElement("right_".$l_right->id,["type"=>"@checkbox","label"=>$l_right->description]);
        }
    }
}