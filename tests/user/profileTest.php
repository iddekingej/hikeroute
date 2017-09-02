<?php 

use Tests\TestCase;
use App\Vc\User\EditPage;
use Illuminate\Support\ViewErrorBag;
use App\Vc\User\AllUserPage;
use XMLView\View\ResourceView;

/**
 *  Test user profile page
 */
class profileTest extends TestCase
{
    
    function testProfilePage()
    {
        $l_name=$this->getAdminUser()->name;
        $this->expectOutputRegex('/'.$l_name.'/s');
        XMLView("user/profile.xml",["user"=>$this->getAdminUser()]);
    }
    
    function testPasswordPage()
    {
        $l_page=new ResourceView("user/password.xml");
        $l_page->display();
        $this->assertEquals(1,1);
    }
    
    function testEditPage()
    {
        $l_page=new EditPage(\Auth::user(), new ViewErrorBag());
        $l_page->display();
        $this->assertEquals(1,1);
    }
    
    function testAllUserPage()
    {
        $l_page=new AllUserPage();
        $l_page->display();
        $this->assertEquals(1,1);
    }
}