<?php 

use App\Models\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\RouteTraceTableCollection;
use XMLView\Engine\Data\MapData;
use App\Vc\Route\EditLayer;
use App\Http\Controllers\RoutesController;

class routePagesTest extends \Tests\TestCase
{
    private $route;
    private $trace;
    const ROUTETITLE="sdasdasd";
    function setup()
    {
        parent::setup();
        $this->loginToTestingUser();
        $l_content=$this->getResource(self::TRACE1);
        $this->trace = RouteTraceTableCollection::addGpxFile($l_content);        
        $this->route = Route::create([
            "id_user" => \Auth::user()->id,
            "title" => static::ROUTETITLE,
            "comment" => "Comment",
            "location" => "LocationTest",
            "id_routetrace" => $this->trace->id,
            "publish" => 1
        ]);
        
    }
    
    
    function testController()
    {
        $l_controller=App::Make(RoutesController::class);
        $l_controller->editRoute($this->route);
        $this->assertEquals(1,1);
    }
    function testEditRoute()
    {
        $this->actingAs($this->getTestingUser())->get("/routes/edit/".$this->route->id)->assertStatus(200)->assertSee(static::ROUTETITLE);
    }
    
    function testRoutesNewDatails()
    {
        $this->actingAs($this->getTestingUser())->get("/routes/newdetails/".$this->trace->id)->assertStatus(200);        
    }
    
    function testEditLayer()
    {
        $l_map=new MapData(null);
        $l_map->setValue("route",$this->route);
        $l_layer=new EditLayer();
        $l_my=$l_layer->processData($l_map);
        $this->assertEquals($this->route->title,$l_my->getValue("title"));
    }
    

    
    function testEditTrace()
    {        
        $this->actingAs($this->getTestingUser())->get("/routes/trace/edit/".$this->route->id)->assertStatus(200)->assertSee("update/".$this->route->id);
    }
    
    function testUpdateTrace()
    {
        $this->actingAs($this->getTestingUser())->get("/routes/trace/update/".$this->route->id."/".$this->trace->id)->assertRedirect("display/trace/".$this->route->id);
    }
    

    function testDelRoute()
    {
        $this->actingAs($this->getTestingUser())->get("/routes/del/".$this->route->id)->assertRedirect(Route("routes"));
       
    }
   
}