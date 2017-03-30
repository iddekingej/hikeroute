<?php 
use PHPUnit\Framework\TestCase;
use App\Models\LocationTableCollection;

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
		$l_locations=LocationTableCollection::getLocation(["city"=>"testxa","state"=>"testxb","country"=>"testxc"]);
		$l_location=end($l_locations);
		$this->assertNotNull($l_location);
		$this->assertEquals("testxc",$l_location->name);
		$l_parent=$l_location->parentLocation()->getResults();
		$this->assertNotNull($l_parent);
		$this->assertEquals("testxb",$l_parent->name);
		$l_locations2=LocationTableCollection::getLocation(["city"=>"testxa","state"=>"testxb","country"=>"testxc"]);
		$l_location2=end($l_locations2);
		$this->assertEquals($l_location->id,$l_location2->id);
	}
}
?>