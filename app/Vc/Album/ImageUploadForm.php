<?php 
namespace App\Vc\Album;
use App\Vc\Lib\Form;
use App\Models\Route;
use Illuminate\Support\ViewErrorBag;

class ImageUploadForm extends Form
{
    function __construct(Route $p_route,ViewErrorBag $p_errors)
    {
        $this->data["image"]="";
        $this->title=__("Upload image");
        $this->url=route("images.save",["id"=>$p_route->id]);
        parent::__construct($p_errors);
    }
    function setup()
    {
        $this->addElements([
            "image"=>["type"=>"@file","label"=>__("Image")]
        ]);
    }
}