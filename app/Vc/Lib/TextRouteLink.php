<?php 
declare(strict_types=1);
namespace App\Vc\Lib;
use App\Vc\Lib\HtmlComponent;

/**
 * A component that displays as link, with route url
 *
 */
class TextRouteLink extends HtmlComponent
{
    /**
     * Route used in URL
     * @var string
     */
    private $route;
    /**
     * Parameters used in url
     * @var array
     */
    private $data;
    /**
     * Text displayed in URL
     * @var string
     */
    private $text;
    
    /**
     * Setup object
     * @param string $p_route
     * @param array $p_data
     * @param string $p_text
     */
    function __construct(string $p_route,?Array $p_data,string $p_text)
    {
        $this->route=$p_route;
        $this->data=$p_data;
        $this->text=$p_text;
        parent::__construct();
    }
    
    
    /**
     * Displayes link
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlComponent::display()
     */
    function display():void
    {
        $this->theme->textRouteLink($this->route,$this->data,$this->text);
    }
}