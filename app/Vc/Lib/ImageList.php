<?php
declare(strict_types=1);
namespace App\Vc\Lib;

class ImageList extends HtmlComponent
{
    private $images;
    function __construct($p_images)
    {
        $this->images=$p_images;
        parent::__construct();
    }
    
    function display()
    {
        foreach($this->images as $l_image)
        {
            $this->theme->route_Album->albumImageHeader();
            $this->theme->route_Album->thumbnail($l_image);
            $this->theme->route_Album->albumImageFooter();
        }
    }

}