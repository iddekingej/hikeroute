<?php 
use PHPUnit\Framework\TestCase;
use App\Models\RouteTraceTableCollection;

class route1Test extends \Tests\TestCase
{
	const TRACE1="2_nov._2016_09_01_26.gpx";
	private $trace;
	function setup()
	{
		parent::setup();
		$l_gpxFileName=self::TRACE1;
		$l_content=$this->getResource($l_gpxFileName);
		$this->trace=RouteTraceTableCollection::addGpxFile($l_content);
	}
	
	function test1UploadRoute()
	{

		$l_file=$this->trace->routeFile()->getResults();
		$this->assertNotNull($l_file);
		$l_size=strlen($l_file->gpxdata);
		$this->assertEquals($this->getResourceLen(self::TRACE1), $l_size);
		
	}
	
	function test2UpdateRoute()
	{
		$l_gpxFileName="2_nov._2016_10_24_21.gpx";
		$l_content=$this->getResource($l_gpxFileName);
		RouteTraceTableCollection::updateGpxFile($this->trace,$l_content);
		$l_file=$this->trace->routeFile()->getResults();
		$l_size=strlen($l_file->gpxdata);
		$this->assertEquals($this->getResourceLen($l_gpxFileName), $l_size);
		
	}
}

?>