<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Vc\Lib\HtmlComponent;
/**
 * Displays a note message
 *
 */
class Note extends HtmlComponent{
    private $text;
    
    function __construct(string $p_text)
    {
        $this->text=$p_text;
        parent::__construct();
    }
    function display():void
    {
        $this->theme->page_Page->note($this->text);        
    }
}