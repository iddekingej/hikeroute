<?php
namespace Tests\routes;
use PHPUnit\Framework\TestCase;
use App\Models\RouteTraceTableCollection;
use App\Models\LocationTableCollection;
use App\Models\TraceLocationTableCollection;
use App\Models\Route;
use App\Vc\Route\TracePage;
use App\Vc\Route\ListPage;
use App\Vc\Route\OverviewPage;
use App\Vc\Route\AlbumPage;
use App\Vc\HomePage;
use Illuminate\Database\Eloquent\Collection;
use App\Models\RouteTableCollection;
use App\Vc\Route\AlbumEditPage;
use App\Models\RouteImageTableCollection;
use App\Location\LocationResult;
use XMLView\View\ResourceView;

class Route1Base extends \Tests\TestCase
{

    private $trace;
    private $route;
    
    function setup()
    {
        parent::setup();
        $l_gpxFileName = self::TRACE1;
        $l_content = $this->getResource($l_gpxFileName);
        $this->trace = RouteTraceTableCollection::addGpxFile($l_content);
        $this->route = Route::create([
            "id_user" => \Auth::user()->id,
            "title" => "title1",
            "comment" => "Comment",
            "location" => "LocationTest",
            "id_routetrace" => $this->trace->id,
            "publish" => 1
        ]);
    }


    function testGetRoute()
    {
        $l_route = Route::findOrFail($this->route->id);
        $this->assertEquals("title1", $l_route->title);
        $this->assertEquals("Comment", $l_route->comment);
        $this->assertEquals("LocationTest", $l_route->location);
        $this->assertEquals($this->trace->id, $l_route->id_routetrace);
        $this->assertEquals(1, $l_route->publish);
    }

    function test1UploadRoute()
    {
        $l_file = $this->trace->routeFile;
        $this->assertNotNull($l_file);
        $l_size = strlen($l_file->gpxdata);
        $this->assertEquals($this->getResourceLen(self::TRACE1), $l_size);
    }

    function test2UpdateRoute()
    {
        $l_gpxFileName = "2_nov._2016_10_24_21.gpx";
        $l_content = $this->getResource($l_gpxFileName);
        RouteTraceTableCollection::updateGpxFile($this->trace, $l_content);
        $l_file = $this->trace->routeFile;
        $l_size = strlen($l_file->gpxdata);
        $this->assertEquals($this->getResourceLen($l_gpxFileName), $l_size);
    }

    function test3Tracelocation()
    {
        $l_result=new LocationResult();
        $l_result->addLocation("country", "QQ");
        $l_result->addLocation("city", "ZZ");
        $l_locations = LocationTableCollection::getLocation($l_result);
        TraceLocationTableCollection::addTraceLocations($this->trace, $l_locations);
        $l_locations = $this->trace->getLocations();
        $this->assertEquals(2, count($l_locations));
        $this->assertEquals("QQ", $l_locations[0]->location->name);
        $this->assertEquals("ZZ", $l_locations[1]->location->name);
        $l_return = TraceLocationTableCollection::getByTraceTypeIndexed($this->trace);
        $this->assertEquals("QQ", $l_return["country"]->name);
        $l_routes=RouteTableCollection::getAccessibleByLocation($l_locations[0]->location->id);
    }

    function test4()
    {
        $this->assertEquals($this->route->routeTrace->id, $this->trace->id);
    }

    function testUpdateInfo()
    {
        $this->route->title = "X2";
        $this->route->comment = "bla123";
        $this->route->location = "XXX";
        $this->route->publish = 0;
        $this->route->save();
        $l_route = Route::findOrFail($this->route->id);
        $this->assertEquals($l_route->title, "X2");
        $this->assertEquals($l_route->comment, "bla123");
        $this->assertEquals($l_route->publish, 0);
    }
    
    function testPageTrace()
    {           
            $this->expectOutputRegex("/".$this->route->title."/s");
            $l_page= new ResourceView("route/Trace.xml",["route"=>$this->route]);
            $l_page->display();            
    }
    
    
    
    function testPageAlbum()
    {
            $l_page=new AlbumPage($this->route);
            $l_page->display();
            $this->assertEquals(1,1);
    }
    
    function testPageAlbumEdit()
    {
        RouteImageTableCollection::addImage($this->route, $this->getResourcePath(static::IMG1_JPEG_TMP), static::IMG1_JPEG);
        $this->expectOutputRegex("/".$this->route->title."/s");
        $l_page=new AlbumEditPage($this->route);
        $l_page->display();        
    }
    
    function testPageOverview()
    {
        $this->expectOutputRegex("/".$this->route->title."/s");
        $l_page=new OverviewPage($this->route);
        $l_page->display();        
        
    }
    
    function testPageList()
    {
        $this->expectOutputRegex("/routes\/new/s");
        $l_page= new ListPage(\Auth::user()->routes());
        $l_page->display();        
    }
    
    function testHomePage()
    {
        $this->expectOutputRegex("/".$this->testUser->name."./s");        
        $l_page=new HomePage(new Collection(), RouteTableCollection::numRoutesByLocation(null), new Collection());
        $l_page->display();
    }
}

?>