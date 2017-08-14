<?php
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Vc\Lib\Engine\Data\DataStore;

/**
 * Displays a information table.
 * This table has 2 columns. 
 * - On the left is a label.
 * - On the right is a information item. 
 */
class InfoTable extends HtmlComponent
{
    use SubItems;
    
    private $title;
    
    /**
     * In this constructor the height is set a minimal as possible
     */
    function __construct()
    {
        parent::__construct();
        $this->setContainerHeight("0px");
    }
    
    /**
     * Above the table there is a title.
     * 
     * @param string $p_title Title of the information table
     */
    function setTitle(string $p_title):void
    {
        $this->title=$p_title;
    }
    
    /**
     * Get the title of the information table 
     * 
     * @return string the title of of the table
     */
    function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Add a text element
     * 
     * @param string $p_label
     * @param string $p_value
     */
    function addText(string $p_label,string $p_value):void
    {
        $this->add(new StaticText($p_label));
        $this->add(new StaticText($p_value));
    }
    
    /**
     * Displays the information table     
     * @see \App\Vc\Lib\HtmlComponent::display()
     */
    function display(?DataStore $p_store=null)
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