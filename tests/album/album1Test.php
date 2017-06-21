<?php 

use Tests\TestCase;
use App\Models\ImageTableCollection;
use App\Models\RouteTraceTableCollection;
use App\Models\Route;
use App\Vc\Album\ImageUploadPage;
use Illuminate\Support\ViewErrorBag;

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
    
    function testImage()
    {
        $l_image=ImageTableCollection::addImage($this->getResourcePath(static::IMG1_JPEG_TMP), static::IMG1_JPEG);
        $this->assertEquals("image/jpeg", $l_image->mimetype);
        $this->assertEquals($this->getResource(static::IMG1_JPEG), $l_image->decodedImage());
    }
    
    function testUloadImageForm()
    {
        $l_form=new ImageUploadPage($this->route, new ViewErrorBag());
        $l_form->display();
        $this->assertEquals(1,1);
    }
    
    function testDeleteRoute()
    {
        $this->route->deleteDepended();
    }
}