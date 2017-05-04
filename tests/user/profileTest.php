<?php 

use App\Vc\User\ProfilePage;
use Tests\TestCase;

class profileTest extends TestCase
{
    
    function testProfilePage()
    {
        $l_page=new ProfilePage($this->getAdminUser());
        $l_page->display();
        $this->assertEquals(1,1);
    }
}