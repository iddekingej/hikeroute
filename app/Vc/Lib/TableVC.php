<?php
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Lib\Page;


/**
 * Displays table from some data.
 * Usages:
 * -Set data by __construct($p_data) $p_data must be iterable or an array.
 * -Set config by setConfig(data)
 * -Define get data=>this method converts item to row data
 * config:
 * [*name1*=>["type"=>*type*,"title"=>"title",*other config*
 * ,*name2*=>[
 * Types:
 * @text -static text (text is escaped)
 * @html - html text
 * @iconlink - Link with an icon
 * @link - text link
 * @iconlinkconfirm - Ion link with confirm message
 */
abstract class TableVC extends ViewComponentBase{
    private $config=[];
    protected $title;
    protected $data;
    protected $custom=[];
    
    function __construct($p_data)
    {
        $this->data=$p_data;
    }
    
    function setConfigItem(string $p_name,string $p_field,$p_value)
    {
        $this->config[$p_name][$p_field]=$p_value;
    }
    
    function setConfigElement(string $p_name,Array $p_data)
    {
        $this->config[$p_name]=$p_data;
    }
    function addConfig(array $p_config)
    {
        $this->config=array_merge($this->config,$p_config);
    }
    

    private function displayTableHeader()
    {
        ?>
        <tr>
        <?php 
        foreach($this->config as $l_name=>$l_info){
            ?><td class="table_header"><?=static::e($l_info["title"])?></td><?php 
        }
        ?>
        </tr>
    	<?php 
    }
    
    /**
     * Get row data van p_info.
     * Returns associate array with row data. Key name is same as in $this->config
     * When return NULL the row is ignore
     * 
     * @param unknown $p_info
     * @return NULL|Array
     */
    protected abstract function getData($p_info);
   
    function printRow($p_config,$p_value,$p_name)
    {
        ?><td class="table_cell"><?php 
            $l_type=$p_config["type"];
            switch($l_type){
                case "@text":
                    echo static::e($p_value);
                    break;
                    
                case "@html":
                    echo $p_value;
                    break;
                    
                case "@iconlink":
                    if($p_value != null){
                        echo static::tag("a")->property("href",$p_value)->inner("img")->property("src",$p_config["icon"])->endInner();
                    }
                    break;
                case "@iconlinkconfirm":
                    if($p_value != null){
                        Page::iconConfirm($p_config["confirmmsg"],$p_value,$p_config["icon"]);
                    }                       
                    break;
                    
                case "@link":
                    ?><a href="<?=static::e($p_value[0])?>"><?=static::e($p_value[1])?></a><?php
                    break;
                    
                default:
                    if(isset($this->custom[$p_name])){
                        $l_object=$this->custom[$p_name];
                    } else {
                        $l_object=new $l_type($p_config);
                        $this->custom[$p_name]=$l_object;
                    }
                    $l_object->display($p_value);
              }
        ?></td><?php 
        
    }
    
    function display()
    {
        ?><table class='tablevc_table'><?php 
        if($this->title != ""){
            ?><tr><td class='tablevc_title' colspan='<?=count($this->config)?>'><?=static::e($this->title)?></td></tr><?php
        }
        $this->displayTableHeader();
        foreach($this->data as $l_row){
            $l_data=$this->getData($l_row);
            if($l_data===null){
                continue;
            }
            ?><tr><?php 
            foreach($this->config as $l_name=>$l_config){
                   $this->printRow($l_config,$l_data[$l_name],$l_name);
            }
            ?></tr><?php 
        }        
        ?></table><?php 
    }
}