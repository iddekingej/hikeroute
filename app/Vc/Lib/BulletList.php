<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Vc\Lib\Engine\Data\DataStore;

class BulletList extends HtmlComponent
{
    private $items=[];
    
    function add(HtmlComponent $p_component){
        $this->items[]=$p_component;
    }
    
    function display(?DataStore $p_store=null)
    {
        $this->theme->base_BulletList->listHeader();
        foreach($this->items as $l_item){
            $this->theme->base_BulletList->itemHeader();
            $l_item->display();
            $this->theme->base_BulletList->itemFooter();
        }
        $this->theme->base_BulletList->listFooter();
    }
}