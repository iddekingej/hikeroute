<?php 
namespace App\Vc\Admin;

use App\Vc\Lib\HtmlPage2;
use App\Vc\Admin\UserForm;
use App\Models\User;
use Illuminate\Support\ViewErrorBag;
use App\Vc\Lib\Align;

class UserAdminPage extends HtmlPage2
{
    private $cmd;
    private $user;
    private $errors;
    
    function __construct(string $p_cmd, ?User $p_user, ViewErrorBag $p_errors)
    {
        $this->user=$p_user;
        $this->cmd=$p_cmd;
        $this->errors=$p_errors;
        parent::__construct();
    }
    
    function setup():void
    {
        parent::setup();
        $this->title=__("Edit or add a new user");
    }
    
    function setupContent():void
    {
        $this->top->add(new UserForm($this->cmd, $this->user, $this->errors),"","",Align::CENTER);
    }
}