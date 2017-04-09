<?php 
use PHPUnit\Framework\TestCase;
use App\Models\RouteTraceTableCollection;
use App\Models\LocationTableCollection;
use App\Models\TraceLocationTableCollection;
use App\Models\Route;

class route1Test extends \Tests\TestCase
{
	const TRACE1="2_nov._2016_09_01_26.gpx";
	private $trace;
	private $route;
	function setup()
	{
		parent::setup();
		$l_gpxFileName=self::TRACE1;
		$l_content=$this->getResource($l_gpxFileName);
		$this->trace=RouteTraceTableCollection::addGpxFile($l_content);
		$this->route=Route::create(["id_user"=>\Auth::user()->id
				,"title"=>"title1"
				,"comment"=>"Comment"
				,"location"=>"LocationTest"
				,"id_routetrace"=>$this->trace->id
				,"publish"=>1
		]);
	}
	/**
	 * In the test method some test data is saved.
	 * Load data and check values
	 */
	function testGetRoute()
	{
		$l_route=Route::findOrFail($this->route->id);
		$this->assertEquals("title1",$l_route->title);
		$this->assertEquals("Comment",$l_route->comment);
		$this->assertEquals("LocationTest",$l_route->location);
		$this->assertEquals($this->trace->id,$l_route->id_routetrace);
		$this->assertEquals(1,$l_route->published);
	}
	
	function test1UploadRoute()
	{

		$l_file=$this->trace->routeFile;
		$this->assertNotNull($l_file);
		$l_size=strlen($l_file->gpxdata);
		$this->assertEquals($this->getResourceLen(self::TRACE1), $l_size);
		
	}
	
	function test2UpdateRoute()
	{
		$l_gpxFileName="2_nov._2016_10_24_21.gpx";
		$l_content=$this->getResource($l_gpxFileName);
		RouteTraceTableCollection::updateGpxFile($this->trace,$l_content);
		$l_file=$this->trace->routeFile;
		$l_size=strlen($l_file->gpxdata);
		$this->assertEquals($this->getResourceLen($l_gpxFileName), $l_size);
		
	}
	
	function test3Tracelocation()
	{
		$l_locations=LocationTableCollection::getLocation(["country"=>"QQ","city"=>"ZZ"]);
		TraceLocationTableCollection::addTraceLocations($this->trace,$l_locations);
		$l_locations=$this->trace->getLocations();
		$this->assertEquals(2,count($l_locations));
		$this->assertEquals("QQ",$l_locations[0]->getLocation()->name);
		$this->assertEquals("ZZ",$l_locations[1]->getLocation()->name);
	}
	
	function test4()
	{
		$this->assertEquals($this->route->routeTrace()->id,$this->trace->id);
	}
	
	/**
	 * Test if update route details will work
	 */
	function testUpdateInfo()
	{
		$this->route->title="X2";
		$this->route->comment="bla123";
		$this->route->location="XXX";
		$this->route->publish=0;
		$this->route->save();
		$l_route=Route::findOrFail($this->route->id);
		$this->assertEquals($l_route->title, "X2");
		$this->assertEquals($l_route->comment,"bla123");
		$this->assertEquals($l_route->publish,0);
	}
}

?>