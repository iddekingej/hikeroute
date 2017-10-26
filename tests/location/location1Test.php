<?php
use PHPUnit\Framework\TestCase;
use App\Models\LocationTableCollection;
use App\Models\LocationTypeTableCollection;
use App\Lib\GPXPoint;
use App\Location\LocationService;
use App\Models\LocationType;
use App\Location\LocationResult;

class location1Test extends \Tests\TestCase
{

    function setup()
    {
        parent::setup();
        DB::statement("delete from locations where name='testxc'");
        DB::statement("delete from locations where name='testxb'");
        DB::statement("delete from locations where name='testxa'");
    }

    function test1Location()
    {
        $l_result=new LocationResult();
        $l_result->addLocation("city","testxa");
        $l_result->addLocation("state","testxb");
        $l_result->addLocation("country","testxc");
        $l_locations = LocationTableCollection::getLocation($l_result);
        $l_location = end($l_locations);
        $this->assertNotNull($l_location);
        $this->assertEquals("testxc", $l_location->name);
        $l_parent = $l_location->parentLocation;
        $this->assertNotNull($l_parent);
        $this->assertEquals("testxb", $l_parent->name);
        $l_locations2 = LocationTableCollection::getLocation($l_result);
        $l_location2 = end($l_locations2);
        $this->assertEquals($l_location->id, $l_location2->id);
    }

    function test2location()
    {
        \App\Location\LocationService::setLocationService("nomatim");
        $l_gpx = new GPXPoint(40 + 44 / 60, - 73 - 51 / 60, "");
        $l_data = (LocationService::locationFromGPX($l_gpx));
        $this->assertEquals( "/United States of America/New York/NYC",$l_data->getFullname());
        sleep(1);
    }

    function test3location()
    {
        $l_gpx = new GPXPoint(0, 0, "");
        $l_data = (LocationService::locationFromGPX($l_gpx));
        $this->assertEquals(null,$l_data);
        sleep(1);
    }   
    /**
     * Checks getLocationType: convert description to locationType Id
     */
    function test4LocationType()
    {
        $l_id=LocationTypeTableCollection::getLocationType("city");
        $this->assertNotNull($l_id);
        $l_item=LocationType::findOrFail($l_id);
        $this->assertEquals("city", $l_item->description);
    }
    
}
?>