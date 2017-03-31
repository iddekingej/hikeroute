<?php 
use PHPUnit\Framework\TestCase;
use App\Models\RouteTraceTableCollection;
use App\Models\LocationTableCollection;
use App\Models\TraceLocationTableCollection;
use App\Models\Route;
use App\Models\RouteTableCollection;

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
	
	function test1UploadRoute()
	{

		$l_file=$this->trace->routeFile();
		$this->assertNotNull($l_file);
		$l_size=strlen($l_file->gpxdata);
		$this->assertEquals($this->getResourceLen(self::TRACE1), $l_size);
		
	}
	
	function test2UpdateRoute()
	{
		$l_gpxFileName="2_nov._2016_10_24_21.gpx";
		$l_content=$this->getResource($l_gpxFileName);
		RouteTraceTableCollection::updateGpxFile($this->trace,$l_content);
		$l_file=$this->trace->routeFile();
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
	
	function test5(){
		$l_locations=LocationTableCollection::getLocation(["country"=>"QQ","city"=>"ZZ"]);
		TraceLocationTableCollection::addTraceLocations($this->trace,$l_locations);
		$this->route->deleteDepended();
	}
}

?>