<?php 
use PHPUnit\Framework\TestCase;
use App\Models\RouteTraceTableCollection;

class route1Test extends \Tests\TestCase
{
	private $trace;
	function test1UploadRoute()
	{
		$l_gpxFileName="2_nov._2016_09_01_26.gpx";
		$l_content=$this->getResource($l_gpxFileName);
		$l_trace=RouteTraceTableCollection::addGpxFile($l_content);
		$l_file=$l_trace->routeFile()->getResults();
		$this->trace=$l_trace;
		$this->assertNotNull($l_file);
		$l_size=strlen($l_file->gpxdata);
		$this->assertEquals($this->getResourceLen($l_gpxFileName), $l_size);
	}
	
	function test2UpdateRoute()
	{
		$l_gpxFile="2_nov_2016_10_21_21.gpx";
		$l_content=$this->getResource($l_gpxFileName);
		RouteTraceTableCollection::updateGpxFile($l_trace,$l_content);
		$l_size=strlen($l_file->gpxdata);
		$this->assertEquals($this->getResourceLen($l_gpxFileName), $l_size);
		
	}
}

?>