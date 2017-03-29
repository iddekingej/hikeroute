<?php 
use PHPUnit\Framework\TestCase;
use App\Models\RouteTraceTableCollection;

class route1Test extends \Tests\TestCase
{
	function testUploadRoute()
	{
		$l_gpxFileName="2_nov._2016_09_01_26.gpx";
		$l_content=$this->getResource($l_gpxFileName);
		$l_trace=RouteTraceTableCollection::addGpxFile($l_content);
		$l_file=$l_trace->routeFile()->getResults();
		$this->assertNotNull($l_file);
		$l_size=strlen($l_file->gpxdata);
		$this->assertEquals($this->getResourceLen($l_gpxFileName), $l_size);
	}
}

?>