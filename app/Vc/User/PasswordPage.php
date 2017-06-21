<?php 
declare(strict_types=1);
namespace App\Vc\User;

use App\Vc\Lib\HtmlPage;
use App\Models\User;
use App\Lib\Frm;

class PasswordPage extends HtmlPage{
    private $errors;
    function __construct($p_errors)
    {        
        $this->errors=$p_errors;
        parent::__construct();
    }
    
    function setup():void
    {
        $this->title=__("Change your password");              
        parent::setup();
    }
    
    function content():void
    {
        Frm::header(__("Change your password"),"user.savepassword", []);
        Frm::password("password", __("New password"), $this->errors, "", "");
        Frm::password("passwordconf", __("Confirm password"), $this->errors, "", "");
        Frm::submit(Route("user.profile"));
        
    }
}