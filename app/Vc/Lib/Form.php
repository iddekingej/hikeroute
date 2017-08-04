<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use Illuminate\Support\ViewErrorBag;

class FormException extends \Exception
{
    
}

/**
 * Display a input form 
 *
 */
abstract class Form extends HtmlComponent
{
    private static $idCnt=0;
    protected $id;
    protected $title;
    protected $url;
    protected $cancelUrl;
    protected $saveText;
    protected $cancelText;
    protected $data=[];
    protected $errors;
    private $elements=[];
    
    /**
     * Get the JS used by form
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlComponent::getJs()
     */
    function getJs():array
    {
        return ["/js/form.js"];
    }
    
    function __construct( ViewErrorBag $p_errors)
    {
        $this->errors=$p_errors;
        self::$idCnt++;
        $this->id="form_".self::$idCnt."_";
        parent::__construct();
    }
    /**
     * Add form element to form
     * 
     * @param unknown $p_name Name of element
     * @param array $p_data Element configuration
     */
    function addElement($p_name,Array $p_data):void
    {
        $this->elements[$p_name]=$p_data;
    }
    
    /**
     * Add Multiple element to form
     * 
     * @param array $p_data
     */
    
    function addElements(Array $p_data)
    {
        foreach($p_data as $l_name=>$l_row){
            $this->addElement($l_name,$l_row);
        }
    }
    
    /**
     * Called before form is displayed
     * 
     * @return array Return data used in form
     */
    protected function preForm():Array
    {
        $l_data=$this->data;
        foreach($l_data as $l_name=>&$l_value){
            $l_value=old($l_name,$l_value);
        }
        return $l_data;
    }
    
    private function dv(Array $p_deffinition,string $p_name,$p_default){
        if(!isset($p_name[$p_deffinition])){
            return $p_default;
        }
        return $p_name[$p_deffinition];
    }
    
    /**
     * Get the dom ID of the element row.
     * 
     * @param unknown $p_name element name
     * @return string
     */
    private function elementRowId(string $p_name):string
    {
        return $this->id."r_".$p_name;
    }
    
    /**
     * Get the dom ID of a element.
     *
     * @param unknown $p_name element name
     * @return string
     */
    private function elementId(string $p_name):string
    {
        return $this->id."r_".$p_name;
    }
    
    
    /**
     * Generates HTML for element
     * 
     * @param unknown $p_name Name of element
     * @param array $p_definition Array with element definition
     * @param unknown $p_value Value stored in element
     * @throws FormException
     */
    function element($p_name,array $p_definition,$p_value){
        $l_error="";
        $l_type=$p_definition["type"];
        if($this->errors->has($p_name)){
            $l_error=$this->errors->first($p_name);
        }
        $this->theme->base_Form->rowHeader($p_name,$p_definition["label"],$l_error,$this->elementRowId($p_name));
        $this->theme->base_Form->elementHeader();
        $l_id=$this->elementId($p_name);
        switch($l_type){
            case "@text":
                $this->theme->base_Form->textElement($l_id,$p_name,$p_value);
                break;
            case "@checkbox":
                $this->theme->base_Form->checkboxElement($l_id,$p_name,$p_value);
                break;
            case "@textarea":
                
                $l_css="width:".$this->dv($p_definition,"width","100%").";";
                $l_css .= "height:".$this->dv($p_definition,"height","100px").";";
                $this->theme->base_Form->textAreaElement($l_id,$p_name,$p_value,$l_css);
                break;
            case "@file":
                $this->theme->base_form->fileInput($l_id,$p_name);
                break;
            default:
                throw new FormException("Invalid element type '$l_type' for element $p_name");
        }
        $this->theme->base_Form->rowFooter();
    }
    /**
     * Setup elements here (user addElement or addElements)
     */
    abstract function setup();
    
    
    /**
     * Display form
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlComponent::display()
     */
    function display()
    {
        $this->setup();
        $l_data=$this->preForm();
        $this->theme->base_Form->formHeader($this->id,$this->url);
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
        $this->theme->base_Form->footer();
        $this->theme->base_Form->formFooter();
        
        $this->theme->jsStart();
        ?>
        var l_form=new form(<?=json_encode($this->id)?>);
        l_form.elementNames=<?=json_encode(array_keys($this->elements))?>;
        l_form.setup();
        <?php 
        $this->theme->jsEnd();
    }
}