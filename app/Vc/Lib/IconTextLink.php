<?php
declare(strict_types=1);
namespace App\Vc\Lib;

/**
 * Text link with an icon in front 
 *
 */
class IconTextLink extends HtmlComponent
{
    private $route;
    private $data;
    private $icon;
    private $text;
    
    /**
     * Initialize the IconTestLinks component
     * 
     * @param string $p_route Route of link
     * @param array $p_data   Parameter data of link
     * @param string $p_icon  Icon url in fron of link
     * @param string $p_text  Link test
     */
    function __construct(string $p_route,?Array $p_data,string $p_icon,string $p_text)
    {
        $this->route=$p_route;
        $this->data=$p_data;
        $this->icon=$p_icon;
        $this->text=$p_text;
        parent::__construct();
    }
    /**
     * Displays html of link
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlComponent::display()
     */
    function display():void
    {
        $this->theme->imageTextLink(Route($this->route,$this->data),$this->icon,$this->text);
    }
}