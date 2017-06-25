<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Lib\Base;

/**
 * Base class of all HtmlComponents
 *
 *
 */
abstract class HtmlComponent extends Base
{
    /**
     * Variable to access themes
     * @var Theme
     */
    protected $theme;
 
    function __construct()
    {
        $this->theme=Theme::new();
    }
    
    /**
     * Get all JS url used by component
     * @return array
     */
    
    function getJs():array
    {
        return [];
    }
    /**
     * Get all css used by component
     * @return array
     */
    function getCss():array
    {
        return [];
    }
    
    /**
     * Display/Generator HTML of component.
     */
    abstract function display();
}