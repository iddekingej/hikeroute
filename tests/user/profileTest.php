<?php 

use Tests\TestCase;
use App\Vc\User\AllUserPage;
use XMLView\View\ResourceView;
use App\Models\User;

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
        $l_page= new ResourceView("user/edit.xml",["user"=>$this->getAdminUser()]);
        $l_page->display();
        $this->assertEquals(1,1);
    }
    
    function testAllUserPage()
    {
        $l_page=new AllUserPage();
        $l_page->display();
        $this->assertEquals(1,1);
    }
    
    function testEditProfilePage()
    {
       \Auth::logout();
        
        $l_password = bcrypt("test");       
        $l_user = User::create([
            'name' => "vvvv",
            'email' => "wwww@xx.com",
            'password' => $l_password,
            "firstname" => "Afn",
            "lastname" => "Lnf"
        ]);
        $this->actingAs($l_user)->post("user/profile/save",["name"=>"xx.name","firstname"=>"XX","lastname"=>"ZZ","email"=>"xx@ee.com"]);
        
    }
}