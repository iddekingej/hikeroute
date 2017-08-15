<?php 
declare(strict_types=1);
namespace App\Vc\Lib\Widgets\Lists;

use App\Vc\Lib\Engine\Data\DataStore;
use App\Vc\Lib\Engine\Data\DynamicValue;
use App\Vc\Lib\Widgets\Base\Widget;
use App\Vc\Lib\SubList;

class BulletList extends Widget
{
    use SubList;
    
    function displayContent(?DataStore $p_store=null)
    {
        $this->theme->base_BulletList->listHeader();
        foreach($this->subItems as $l_item) {
            $this->theme->base_BulletList->itemHeader();
            $l_item->display($p_store);
            $this->theme->base_BulletList->itemFooter();
        }
        $this->theme->base_BulletList->listFooter();
    }
}