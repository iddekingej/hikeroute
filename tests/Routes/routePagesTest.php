<?php 

use App\Models\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\RouteTraceTableCollection;

class routePagesTest extends \Tests\TestCase
{
    private $route;
    private $trace;
    const ROUTETITLE="sdasdasd";
    function setup()
    {
        parent::setup();
        $this->loginToAdmin();
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
    
    function testRoutesNewDatails()
    {
        $this->actingAs($this->getAdminUser())->get("/routes/newdetails/".$this->trace->id)->assertStatus(200);        
    }
    
    function testEditTrace()
    {        
        $this->actingAs($this->getAdminUser())->get("/routes/trace/edit/".$this->route->id)->assertStatus(200)->assertSee("update/".$this->route->id);
    }
    
    function testUpdateTrace()
    {
        $this->actingAs($this->getAdminUser())->get("/routes/trace/update/".$this->route->id."/".$this->trace->id)->assertRedirect("display/trace/".$this->trace->id);
    }
    
    function testEditRoute()
    {
        $this->actingAs($this->getAdminUser())->get("/routes/edit/".$this->route->id)->assertStatus(200)->assertSee(static::ROUTETITLE);
    }

    function testDelRoute()
    {
        $this->actingAs($this->getAdminUser())->get("/routes/del/".$this->route->id)->assertRedirect(Route("routes"));
       
    }
    
}