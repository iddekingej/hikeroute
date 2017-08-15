<?php 
declare(strict_types=1);
namespace App\Vc\Lib\Widgets\Lists;

use App\Vc\Lib\Widgets\Base\Widget;
use App\Vc\Lib\Engine\Data\DynamicValue;
use App\Vc\Lib\SubList;
use App\Vc\Lib\Engine\Data\DataStore;


class DynamicBulletItem extends Widget
{
    use SubList;
    
    /**
     * List of data used for 
     * 
     * @var DynamicValue
     */
    private $data;
    
    function setData(DynamicValue $p_data):void
    {
        $this->data=$p_data;
    }
    
    function getData():?DynamicValue
    {
        return $this->data;
    }
    
    function displayContent(?DataStore $p_store)
    {
        $l_data=$this->getAttValue("data",$p_store,"",true);
        $l_items=$this->subItems;
        foreach($l_data as $l_row){
            $this->theme->base_BulletList->itemHeader();            
            foreach($l_items as $l_item){
                $l_item->display($l_row);
            }
            $this->theme->base_BulletList->itemFooter();            
        }
    }
}