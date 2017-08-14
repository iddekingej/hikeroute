<?php 
declare(strict_types=1);
namespace App\Vc\User;

use App\Vc\Lib\HtmlPage;
use App\Lib\Frm;
use App\Models\User;
use Illuminate\Support\ViewErrorBag;
use App\Vc\Lib\Engine\Data\DataStore;
/**
 * Edit userdata by administrator
  *
 */
class EditPage extends HtmlPage
{
    private $user;
    private $errors;
    
    function __construct(User $p_user,ViewErrorBag $p_errors)
    {
        $this->user=$p_user;
        $this->errors=$p_errors;
        parent::__construct();
    }
    
    /**
     * Form for changing user data by administrator
     * TODO Change to pure VC compontents
     */
    function content(?DataStore $p_store=null):void
    {
        Frm::header(__("Edit profile"),"user.saveprofile", []);
        Frm::text("name", __("Nick name"), $this->user->name, $this->errors);
        Frm::text("firstname", __("First name"), $this->user->firstname, $this->errors);
        Frm::text("lastname", __("Last name"), $this->user->lastname, $this->errors);
        Frm::text("email", __("Email"), $this->user->email, $this->errors);
        Frm::submit(Route("user.profile"));
    }
}