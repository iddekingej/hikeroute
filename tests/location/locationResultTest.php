<?php 

use App\Location\LocationResult;

class locationResultTest extends \Tests\TestCase
{
    
    function testStore()
    {
        $l_obj=new LocationResult();
        $l_obj->addLocation("A", "B");
        $this->assertEquals("B", $l_obj->getLocation("A"));        
    }
    
    function testExists()
    {
        $l_obj=new LocationResult();
        $l_obj->addLocation("A","C");
        $this->assertEquals(true, $l_obj->hasLocation("A"));        
    }
    
    function testNotExists()
    {
        $l_obj=new LocationResult();
        $l_obj->addLocation("B", "C");
        $this->assertEquals(false, $l_obj->hasLocation("A"));
    }
}