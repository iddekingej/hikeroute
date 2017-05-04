<?php 
declare(strict_types=1);
namespace App\Vc\User;

use App\Vc\UserVC;
use App\Models\User;
use App\Vc\Lib\HtmlMenuPage;

class ProfilePage extends HtmlMenuPage
{
    private $user;
    
    function __construct(User $p_user)
    {
        $this->user=$p_user;
        parent::__construct();
    }
    
    function setup()
    {
        $this->currentTag="profile";
        $this->title=__("User profile");
        parent::setup();
    }
    function content()
    {
        UserVC::profile($this->user);
        
    }
}