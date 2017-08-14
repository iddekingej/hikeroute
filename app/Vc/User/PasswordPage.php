<?php 
declare(strict_types=1);
namespace App\Vc\User;

use App\Vc\Lib\HtmlPage;
use App\Models\User;
use App\Lib\Frm;
use App\Vc\Lib\Engine\Data\DataStore;

/**
 * Change password of current user
 */
class PasswordPage extends HtmlPage{
    
    function __construct($p_errors)
    {                
        $this->setErrors($p_errors);
        parent::__construct();
    }
    /**
     * Setup page
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlPage::setup()
     */
    
    function setup():void
    {
        $this->title=__("Change your password");              
        parent::setup();
    }
    
    
    /***
     * Display password change form
     * 
     * TODO Change to pure VC
     */
    
    function content(?DataStore $p_store=null):void
    {
        Frm::header(__("Change your password"),"user.savepassword", []);
        Frm::password("password", __("New password"), $this->getErrors(), "", "");
        Frm::password("passwordconf", __("Confirm password"), $this->getErrors(), "", "");
        Frm::submit(Route("user.profile"));
        
    }
}