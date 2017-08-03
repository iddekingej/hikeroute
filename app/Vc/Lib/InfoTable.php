<?php
declare(strict_types=1);
namespace App\Vc\Lib;

/**
 * Displays a list of thumbnails to album images
 * 
 */
class InfoTable extends HtmlComponent
{
    use SubItems;
    
    private $title;
    
    function setTitle(string $p_title):void
    {
        $this->title=$p_title;
    }
    
    function getTitle()
    {
        return $this->title;
    }
    
    function addText(string $p_label,string $p_value):void
    {
        $this->add(new StaticText($p_label));
        $this->add(new StaticText($p_value));
    }
    
    function display()
    {
        $l_num=count($this->subItems)/2;
        $this->theme->base_InfoTable->header($this->title);
        for($l_cnt=0;$l_cnt<$l_num;$l_cnt++){
            $this->theme->base_InfoTable->labelHeader();
            $this->subItems[$l_cnt*2]->display();
            $this->subItems[$l_cnt*2+1]->display();
            $this->theme->base_InfoTable->valueFooter();
        }
        $this->theme->base_InfoTable->footer();
    }
}