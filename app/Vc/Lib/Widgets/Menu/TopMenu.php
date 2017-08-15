<?php 
declare(strict_types=1);
namespace App\Vc\Lib\Widgets\Menu;

use App\Vc\Lib\Engine\Data\DataStore;
use App\Vc\Lib\Widgets\Base\Widget;
use App\Vc\Lib\SubList;
use App\Vc\Lib\HtmlComponent;
use App\Vc\Lib\Widgets\Base\WrongWidgetTypeException;

/**
 * 
 * Another horizontal menu 
 *
 */

class TopMenu extends Widget
{
    use SubList;
    
    function __construct()
    {
        parent::__construct();
        $this->setContainerWidth("100%");
        $this->setContainerHeight("0px");
        
    }
 
    
     function validateSubItem(HtmlComponent $p_compontent)
     {
         if($p_compontent instanceof TopMenuItemBase){
             throw new WrongWidgetTypeException(TopMenuItemBase::class, $p_compontent) ;
         }
     }
    
    /**
     * Display menu 
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlComponent::display()
     */
    function display(?DataStore $p_store=null):void
    {
        if($this->items){
            $this->theme->menu_TopMenu->topMenuHeader();
            foreach($this->subItems as $l_item){
                $l_item->display();
            }
           $this->theme->menu_TopMenu->topMenuFooter();
        }
    }
}