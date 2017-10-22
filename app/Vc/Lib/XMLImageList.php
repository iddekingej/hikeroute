<?php
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Models\Image;
use XMLView\Engine\Data\DataStore;;
use XMLView\Widgets\Base\Widget;
use XMLView\Engine\Data\DynamicValue;

/**
 * Displays a list of thumbnails  of a given list images
 * When the user clicks a image an larger image is displayed 
 * 
 */
class XMLImageList extends Widget
{
    /**
     * List of Image objects that is displayed
     * 
     * @var DynamicValue
     */
    private $images;
    
   
    
    /**
     * Sets a list of images that should be displayed
     * 
     * @param unknown $p_images  A list of Image model  objects
     */
    function setImages(DynamicValue $p_images):void
    {
        $this->images=$p_images;
    }
    
    
    /**
     * 
     * @return unknown list of Image models that are displayed
     */
    function getImages():?DynamicValue
    {
        return $this->images;
    }
    /**
     * Display  a list of thumbnails of the images.
     * If the user clicks the thumbnail, a bigger image is displayed
     */
    function displayContent(?DataStore $p_store=null):void
    {
        $l_images=$this->getAttValue("images", $p_store);
        foreach($l_images as $l_image)
        {
            $this->theme->app_route_Album->albumImageHeader();
            $this->theme->app_route_Album->thumbnail($l_image);
            $this->theme->app_route_Album->albumImageFooter();
        }
    }

}