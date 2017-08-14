<?php
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Vc\Lib\Engine\Data\DataStore;

/**
 * Displays a  txt link with an icon in the front.
 * 
 * The url of the link is given by a route name and route parameters.
 *
 */
class IconTextLink extends HtmlComponent
{
    private $route;
    private $parameters;
    private $icon;
    private $text;

    /**
     * Set the route name of the url
     * 
     * @param string $p_route Route name
     */
    function setRoute(string $p_route):void
    {
        $this->route=$p_route;
    }
    
    /**
     * Get the route name of the link
     * @return 
     */
    function getRoute()
    {
        return $this->route;
    }
    
    /** 
     * Set the route parameters of the link 
     * 
     * @param array $p_parameters Associative used a route parameter
     */
    function setParameters(Array $p_parameters):void
    {
        $this->parameters=$p_parameters;
    }
    /**
     * Get Route parameters.
     * 
     * @return array
     */
    function getParameters()
    {
        return $this->parameters;
    }
    
    /**
     * Relative (to the public folder) url to the image. 
     * @param string $p_icon
     */
    function setIcon(string $p_icon):void
    {
        $this->icon=$p_icon;
    }
    
    /**
     * Get the url to the icon image.
     * 
     * @return string Icon url
     */
    function getIcon():string
    {
        return $this->icon;
    }
    
    /**
     * Set the text displayed in the link.
     * This text is html escaped before displaying.
     * 
     * @param string $p_text Text displayed in the link
     */
    function setText(string $p_text):void
    {
        $this->text=$p_text;
    }
    
    /**
     * Get the text displayed in the link.
     * 
     * @return string 
     */
    function getText()
    {
        return $this->text;
    }
    
    /**
     * Initialize the IconTestLinks component
     * 
     * @param string $p_route Route of link
     * @param array $p_data   Parameter data of link
     * @param string $p_icon  Icon url in fron of link
     * @param string $p_text  Link test
     */
    function __construct(string $p_route="",?Array $p_data=[],string $p_icon="",string $p_text="")
    {
        $this->route=$p_route;
        $this->parameters=$p_data;
        $this->icon=$p_icon;
        $this->text=$p_text;
        parent::__construct();
        $this->setContainerWidth("100%");
        $this->setContainerHeight("0px");
    }
    /**
     * Displays link.  
     */
    function display(?DataStore $p_store=null):void
    {
        $this->theme->imageTextLink(Route($this->route,$this->parameters),$this->icon,$this->text);
    }
}