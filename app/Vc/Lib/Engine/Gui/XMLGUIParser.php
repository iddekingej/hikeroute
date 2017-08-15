<?php

namespace App\Vc\Lib\Engine\Gui;

use App\Vc\Lib\HtmlComponent;
use App\Vc\Lib\Engine\XMLClassParser;
use App\Vc\Lib\Engine\XMLClassHandler;
use App\Vc\Lib\Engine\Data\DataLayer;
use App\Vc\Lib\Widgets\Base\Widget;
use App\Vc\Lib\Widgets\Base\GUIFragment;

class XMLGUIParser extends XMLClassParser
{
    function checkTopNode(\DOMNode $p_node):void
    {
        if($p_node->nodeName != "fragment"){
            throw new XMLParserException("Top node must be a 'page' node");
        }
    }
    
    function setupHandlers()
    {
        $this->addHandler("fragment",new XMLClassHandler(GUIFragment::class, GUIFragment::class, null,""));
        $this->addHandler("element",new XMLClassHandler(null, HtmlComponent::class, Widget::class,"add"));
        $this->addHandler("datalayer",new XMLClassHandler(null,DataLayer::class, Widget::class,"setDataLayer"));
    }
}