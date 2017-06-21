<?php 
declare(strict_types=1);
namespace App\Vc\Album;

use App\Vc\Lib\HtmlPage;
use App\Models\Route;
use App\Lib\Frm;

/**
 * Page for uploading a image
 */
class ImageUploadPage extends HtmlPage{
    private $route;
    private $errors;
    
    function __construct(Route $p_route,$p_errors)
    {
        $this->route=$p_route;
        $this->errors=$p_errors;
        parent::__construct();
    }
/**
 * Display the upload form
 * {@inheritDoc}
 * @see \App\Vc\Lib\HtmlPage::content()
 */    
    function content():void
    {
        Frm::header(__("Upload image"), "images.save", ["id"=>$this->route->id]);
        Frm::file("image",__("Image"),$this->errors);
        Frm::submit(Route("display.overview",["id"=>$this->route->id]));
    }
}
    