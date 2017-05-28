<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use Illuminate\Support\ViewErrorBag;

class FormException extends \Exception
{
    
}

abstract class Form extends HtmlComponent
{
    protected $title;
    protected $url;
    protected $cancelUrl;
    protected $saveText;
    protected $cancelText;
    protected $data=[];
    protected $error;
    private $elements=[];
    
    function __construct( ViewErrorBag $p_errors)
    {
        $this->errors=$p_errors;
        parent::__construct();
    }
    
    function addElement($p_name,Array $p_data):void
    {
        $this->elements[$p_name]=$p_data;
    }
    
    function addElements(Array $p_data)
    {
        foreach($p_data as $l_name=>$l_row){
            $this->addElement($l_name,$l_row);
        }
    }
    
    function preForm()
    {
        $l_data=$this->data;
        foreach($l_data as $l_name=>&$l_value){
            $l_value=old($l_name,$l_value);
        }
        return $l_data;
    }
    
    private function dv(Array $p_deffinition,$p_name,$p_default){
        if(!isset($p_name[$p_deffinition])){
            return $p_default;
        }
        return $p_name[$p_deffinition];
    }
    
    function element($p_name,array $p_definition,$p_value){
        $l_error="";
        $l_type=$p_definition["type"];
        if($this->errors->has($p_name)){
            $l_error=$this->errors->first($p_name);
        }
        $this->theme->base_Form->rowHeader($p_name,$p_definition["label"],$l_error);
        $this->theme->base_Form->elementHeader();
        switch($l_type){
            case "@text":
                $this->theme->base_Form->textElement($p_name,$p_value);
                break;
            case "@checkbox":
                $this->theme->base_Form->checkboxElement($p_name,$p_value);
                break;
            case "@textarea":
                
                $l_css="width:".$this->dv($p_definition,"width","100%").";";
                $l_css .= "height:".$this->dv($p_definition,"height","100px").";";
                $this->theme->base_Form->textAreaElement($p_name,$p_value,$l_css);
                break;
            default:
                throw new FormException("Invalid element type '$l_type' for element $p_name");
        }
        $this->theme->base_Form->rowFooter();
    }
    
    abstract function setup();
    
    function display()
    {
        $this->setup();
        $l_data=$this->preForm();
        $this->theme->base_Form->formHeader($this->url);
        $this->theme->base_Form->header($this->title);
        foreach($this->elements as $l_name=>$l_definition){
            $this->element($l_name,$l_definition,$l_data[$l_name]);
        }
        $this->theme->base_Form->submitHeader($this->saveText?$this->saveText:__("Save"));        
        if($this->cancelUrl){
            $l_js="window.location=".json_encode($this->cancelUrl);
            $this->theme->base_Form->submitCancelButton($this->cancelText?$this->cancelText:__("Cancel"),$l_js);
        }

        $this->theme->base_Form->submitFooter();
        $this->theme->base_Form->formFooter();
        $this->theme->base_Form->footer();
    }
}