<?php
use PHPUnit\Framework\TestCase;
use App\Models\RouteTraceTableCollection;
use App\Models\Route;
use App\Http\Controllers\RoutesController;
use Illuminate\Support\Facades\App;


class RouteControllerTest extends \Tests\TestCase
{


    private $trace;

    private $route;
    private $controller;
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
        $this->controller=App::Make(RoutesController::class);
    }
    
    function testEditRoute()
    {
        $this->controller->editRoute($this->route->id);
    }
}