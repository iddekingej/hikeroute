<?php
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Vc\Lib\HtmlComponent;

/**
 *  A vertical list of links with a icon in front of the link 
 */
class IconTextLinks extends HtmlComponent
{
    private $items;
    
    /**
     * Add Icon and text link to Icon link list
     * 
     * @param string $p_icon     Icon URL
     * @param string $p_route    Link route 
     * @param array $p_data      Route parameters
     * @param string $p_text     Route text
     */
    function addItem(string $p_icon,string $p_route,Array $p_data,string $p_text):void
    {
        $this->items[]=[$p_icon,$p_route,$p_data,$p_text];
    }
    
    /**
     * Display Icon text links
     */
    final function display():void
    {
        $this->theme->base_IconTextLinks->header();
        foreach($this->items as $l_item){
            $this->theme->base_IconTextLinks->row($l_item[0],$l_item[1],$l_item[2],$l_item[3]);
        }
        $this->theme->base_IconTextLinks->footer();
    }
}