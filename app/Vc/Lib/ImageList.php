<?php
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Models\Image;
use App\Vc\Lib\Engine\Data\DataStore;

/**
 * Displays a list of thumbnails  of a given list images
 * When the user clicks a image an larger image is displayed 
 * 
 */
class ImageList extends HtmlComponent
{
    /**
     * List of Image objects that is displayed
     * 
     * @var unknown
     */
    private $images;
    
    /**
     * Sets up the object
     * @param unknown $p_images list of images displayed.
     */
    function __construct($p_images=null)
    {
        $this->images=$p_images;
        parent::__construct();
    }
        
    /**
     * Sets a list of images that should be displayed
     * 
     * @param unknown $p_images  A list of Image model  objects
     */
    function setImages($p_images):void
    {
        $this->images=$p_images;
    }
    
    
    /**
     * 
     * @return unknown list of Image models that are displayed
     */
    function getImages()
    {
        return $this->images;
    }
    /**
     * Display  a list of thumbnails of the images.
     * If the user clicks the thumbnail, a bigger image is displayed
     */
    function display(?DataStore $p_store=null):void
    {
        foreach($this->images as $l_image)
        {
            $this->theme->route_Album->albumImageHeader();
            $this->theme->route_Album->thumbnail($l_image);
            $this->theme->route_Album->albumImageFooter();
        }
    }

}