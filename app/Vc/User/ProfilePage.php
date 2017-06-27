<?php 
declare(strict_types=1);
namespace App\Vc\User;


use App\Lib\Icons;
use App\Vc\Lib\HtmlMenuPage;
use App\Models\User;
/**
 * Display profile page of current user
 * 
 * @author jeroen
 *
 */
class ProfilePage extends HtmlMenuPage
{
    private $user;
    
    function __construct(User $p_user)
    {
        $this->user=$p_user;
        parent::__construct();
    }
    
    /**
     * Setup profile page
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlMenuPage::setup()
     */
    function setup():void
    {
        $this->setCurrentTag("profile");
        $this->title=__("User profile");
        parent::setup();
    }
    
    /** 
     * Output profile page 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlPage::content()
     */
    function content():void
    {
        $this->theme->user_Profile->profileHeader();
        $this->theme->user_Profile->profileRow(__("Nick name"), $this->user->name);
        $this->theme->user_Profile->profileRow(__("First name"), $this->user->firstname);
        $this->theme->user_Profile->profileRow(__("Last name"), $this->user->lastname);
        $this->theme->user_Profile->profileRow(__("Email address"), $this->user->email);
        $this->theme->user_Profile->profileEnd();
        $this->theme->imageTextLink(route("user.editprofile"),Icons::EDIT ,__("Edit profile"));
        $this->theme->imageTextLink(route("user.editpassword"),Icons::EDIT ,__("Edit password"));
        $this->theme->user_Profile->profileFooter();
    }
}