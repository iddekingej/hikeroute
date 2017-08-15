<?php 
use Tests\TestCase;
use App\Vc\Lib\Engine\Gui\XMLGUIParser;
use App\Vc\Lib\Engine\Alias\AliasManager;
use App\Vc\Lib\Engine\Alias\AliasList;
use App\Vc\Lib\Engine\Alias\AliasException;
use App\Vc\Lib\Engine\Gui\XMLResourcePage;
use App\Vc\Lib\Engine\Data\MapData;
use App\Vc\Lib\Widgets\Base\GUIFragment;

require_once __DIR__."/TestComponent.php";
class EngineTest extends TestCase
{
    private $data;
    private $gui;   
    private $page;
    function getData($p_name)
    {
        return $this->data[$p_name];
    }
   
    function setup()
    {
        parent::setup();
        AliasManager::resetAliases();        
        AliasManager::addAliasFile($this->getRelativeResourcePath("alias.xml"));        
        $this->page=new XMLResourcePage();
        $this->gui=new stdClass();
    }
    
    function testAlias1()
    {        
        $l_result=AliasManager::getAlias(AliasList::TYPE_ELEMENT, 'test_TestComponent');        
        $this->assertEquals("TestComponent",$l_result);     
    }
    
    function testAlias2()
    {        
        $this->expectException(AliasException::class);
        $l_result=AliasManager::getAlias(AliasList::TYPE_ELEMENT, 'xx###a   aa');
    }
    
    function testBase()
    {
        $l_path=$this->getResourcePath("gui1.xml");
        $l_parser=new XMLGUIParser();
        
        $l_code=$l_parser->parseXML($l_path);
        $l_parent=$this->page;
        echo $l_code;
        $l_return=eval($l_code);
        
        $this->assertInstanceOf(GUIFragment::class,$l_return);
        
        $l_data=new MapData(null,["text"=>"ZZQQbla123"]);        
        $this->expectOutputRegex("/ZZQQbla123/");
        $l_return->display($l_data);
    }
}