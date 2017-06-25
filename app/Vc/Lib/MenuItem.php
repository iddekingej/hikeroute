<?php
declare(strict_types=1);
namespace App\Vc\Lib;

/**
 * 
 * Menu item used in LeftMenu. This object is added to
 * a MenuGroup
 *
 */
abstract class MenuItem extends HtmlComponent
{
    private $tag;
    
    /**
     * Setup MenuItem
     * @param string $p_tag unique ID of menu item
     */
    function __construct(string $p_tag)
    {
        $this->tag=$p_tag;
        parent::__construct();
    }
    
    /**
     * Get unique ID of menu item
     * @return string
     */
    function getTag():string
    {
        return $this->tag;
    }
}