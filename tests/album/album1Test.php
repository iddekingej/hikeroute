<?php 

use Tests\TestCase;

class album1Test extends TestCase
{
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
    
    
}