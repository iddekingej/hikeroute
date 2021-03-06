<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use Illuminate\Support\ViewErrorBag;
use App\Vc\Form\FormException;
use App\Vc\Form\FormElement;
use XMLView\Engine\Data\DataStore;;
use App\Vc\Lib\Engine\Data\DynamicStaticValue;
use App\Vc\Lib\Engine\Data\MapData;


/**
 * Display a input form 
 *
 */
class Form extends HtmlComponent
{
    private static $idCnt=0;
    protected $id=null;
    protected $title;
    protected $route;
    protected $routeParams;
    protected $url;
    protected $cancelUrl;
    protected $saveText;
    protected $cancelText;
    protected $data=[];
    protected $errors;
    private $elements=[];
    private $hidden=[];
    static  private $buildIn=[
        "@checkbox"=>"FormCheckbox",
        "@file"=>"FormFile",
        "@password"=>"FormPassword",
        "@section"=>"FormSection",
        "@text"=>"FormText",
        "@textarea"=>"FormTextArea"
    ];
    
    
    
    /**
     * Setup form
     * 
     * @param ViewErrorBag|null $p_errors Errors displayed in form (used after submit and return to form)
     */
    function __construct( ?ViewErrorBag $p_errors=null)
    {
        if($p_errors==null){
            $this->errors=new ViewErrorBag();   
        } else {
            $this->errors=$p_errors;
        }
        self::$idCnt++;
        $this->id="form_".self::$idCnt."_";
        parent::__construct();
    }
     
    function setData(Array $p_data):void
    {
        $this->data=new DynamicStaticValue($p_data);
    }
    
    
    function getData()
    {
        return $this->data;
    }
    
    function setUrl(string $p_url):void
    {
        $this->url=$p_url;
    }
    
    function getUrl():string
    {
        return $this->url;
    }
    
    /**
     * Add a hidden value 
     * @param string  $p_name   name of hidden value
     * @param unknown $p_valeu  value of the hidden element
     */
    function addHidden(string $p_name,$p_value){
        $this->hidden[$p_name]=$p_value;
    }
    
    /**
     * Get the JS used by form
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlComponent::getJs()
     */
    function getJs():array
    {
        return ["/js/form.js"];
    }
    
    /**
     * Add a form element to a form
     * 
     * @param HtmlComponent $p_component
     * @throws FormException
     * @return HtmlComponent
     */
    function add(HtmlComponent $p_component):HtmlComponent
    {
        if(!($p_component instanceof FormElement)){
            throw new FormException("Element is not a instance of FormElement");
        }
        if($p_component->getName()==""){
            throw new FormException(__("Form element of type ':type' has a empty name ",["type"=>get_class($p_component)]));
        }        
        $p_component->setId($this->elementId($p_component->getName()));
        $p_component->setRowId($this->elementRowId($p_component->getName()));
        $p_component->setName($p_component->getName());
        if($this->errors->has($p_component->getName())){
            $l_error=$this->errors->first($p_component->getName());
            $p_component->setError($l_error);
        }
        $this->elements[$p_component->getName()]=$p_component;
        
        return $p_component;
    }
        
    
    /**
     * Add form element to form
     * 
     * @param unknown $p_name Name of element
     * @param array $p_data Element configuration
     */
    function addElement($p_name,Array $p_data):void
    {
        $l_type=$p_data["type"];
        if($l_type[0]=="@"){
            $l_class="\\App\\Vc\\Form\\".self::$buildIn[$l_type];
        } else {
            $l_class=$l_type;
        }
        $l_object=new $l_class();
        $l_object->setName($p_name);
        foreach($p_data as $l_key=>$l_value){
            if($l_key != "type"){
                $l_method="set${l_key}";
                $l_object->$l_method($l_value);
            }
        }
        $this->add($l_object);
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
    protected function preForm(?MapData $p_store):Array
    {
        $l_data=$this->data;
        foreach($l_data as $l_name=>&$l_value){
            $l_value=old($l_name,$l_value);
        }
        return $l_data;
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
        return $this->id.$p_name;
    }
    
    
    /**
     * Setup elements here (user addElement or addElements)
     */
    function setup(){
        
    }    
    
    function generateConditionJs()
    {
        ?>l_form.checkConditions=function(){
        	var form=this.form;
        <?php
        foreach($this->elements as $l_name=>$l_element){
            if($l_element->getCondition()){
                ?>this.showElement(<?=json_encode($l_name)?>,<?=$l_element->getCondition()?>);
                <?php 
            }       
        }
        ?>};<?php
    }
    
    /**
     * Display form
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlComponent::display()
     */
    function display(?DataStore $p_store=null)
    {        
        
        /**
         * This code is needed for getting the error data to the 
         */
        if(!$this->errors){
            $this->errors=$this->getPage()->getErrors();
        }
        
        $this->setup();
        $l_data=$this->preForm($p_store);
        $this->theme->base_Form->formHeader($this->id,$this->url);
        foreach($this->hidden as $l_name=>$l_value){
            $this->theme->base_Form->hidden($l_name,$l_value);
        }
        $this->theme->base_Form->header($this->title);
        foreach($this->elements as $l_name=>$l_element){
            if($l_element->hasData()){
                if(!array_key_exists($l_element->getName(),$l_data)){
                    throw new FormException(__("Data not found for element ':name' for type ':type'",["name"=>$l_element->getName(),"type"=>get_class($l_element)]));
                }
                $l_element->setValue($l_data[$l_element->getName()]);
            }
            $l_element->display();
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
        <?php 
        $this->generateConditionJs();
        ?>        l_form.setup();
        <?php 
        $this->theme->jsEnd();
    }
}