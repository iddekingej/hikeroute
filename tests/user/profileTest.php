<?php 

use App\Vc\User\ProfilePage;
use Tests\TestCase;
use App\Vc\User\PasswordPage;
use Illuminate\Container\Container;
use Illuminate\Support\MessageBag;

class profileTest extends TestCase
{
    
    function testProfilePage()
    {
        $l_page=new ProfilePage($this->getAdminUser());
        $l_page->display();
        $this->assertEquals(1,1);
    }
    
    function testPasswordPage()
    {
        $l_page=new PasswordPage(new MessageBag());
        $l_page->display();
        $this->assertEquals(1,1);
    }
}