<?php 
declare(strict_types=1);
namespace App\Vc\User;


use App\Lib\Icons;
use App\Vc\Lib\HtmlMenuPage;
use App\Models\User;
use App\Vc\Lib\HtmlMenuPage2;
use App\Vc\Lib\InfoTable;
use App\Vc\Lib\IconTextLink;
use App\Vc\Lib\Spacer;
/**
 * Display profile page of current user
 * 
 * @author jeroen
 *
 */
class ProfilePage extends HtmlMenuPage2
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
    function setupContent():void
    {
        
        
        $l_table=new InfoTable();
        $this->top->add($l_table,'100%','0px');
        $l_table->setTitle(__("User profile"));
        $l_table->addText(__("Nick name"), $this->user->name);
        $l_table->addText(__("First name"), $this->user->firstname);
        $l_table->addText(__("Last name"), $this->user->lastname);
        $l_table->addText(__("Email address"), $this->user->email);
        $this->top->add(new IconTextLink("user.editprofile",[],Icons::EDIT,__("Edit profile")),'100%','0px');
        $this->top->add(new IconTextLink("user.editpassword",[],Icons::EDIT ,__("Edit password")),'100%','0px');
        $this->top->add(new Spacer(Spacer::VERTICAL));
    }
}