<?php 
declare(strict_types=1);
namespace App\Vc\Album;

use App\Models\Route;
use App\Vc\Lib\HtmlPage2;
use App\Vc\Lib\Align;

/**
 * Page for uploading a image
 */
class ImageUploadPage extends HtmlPage2{
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
    function setupContent():void
    {
        $l_form=new ImageUploadForm($this->route,$this->errors);
        $this->top->add($l_form);
    }
}
    