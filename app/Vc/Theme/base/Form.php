<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Base;

use App\Vc\Lib\ThemeItem;

class Form extends ThemeItem
{
    function formHeader($p_url)
    {
        ?><form method="post" action="<?=$this->e($p_url)?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?=$this->e(csrf_token())?>" />
        <?php 
    }
    function  header($p_title)
    {
        ?><table class="formTable"><tr><td class="formTitle" colspan='2'><?=$this->e($p_title)?></td></tr><?php 
    }
    
    function rowHeader($p_field,$p_label,$p_error)
    {
        ?><tr><td >
        	<div class="formLabel">
        	<label for="<?=$this->e($p_field)?>">
        	<?=$this->e($p_label)?>
        	</label>
        	
        	<?php if($p_error){?><div class="formError"><?=$this->e($p_error)?></div><?php }?>
        	</div>
        	</td><?php 
    }
    
    function elementHeader()
    {
        ?><td><?php 
    }
    function rowFooter()
    {
        ?></td></tr><?php 
    }
    
    function submitHeader($p_submitText)
    {
        ?><tr><td colspan='2'><input type='submit' value="<?=$this->e($p_submitText)?>" /><?php 
    }
    
    function submitCancelButton($p_text,$p_js)
    {
       ?><input type='button' value="<?=$this->e($p_text)?>" onclick="<?=$this->e($p_js)?>"/> <?php 
    }
    
    function textElement($p_name,$p_value)
    {
        ?><input type="text" name="<?=$this->e($p_name)?>" value="<?=$this->e($p_value)?>" /><?php
    }
    
    function checkboxElement($p_name,$p_checked)
    {
        $l_checked=$p_checked?'checked="1"':"";            
        ?><input type="checkbox" name="<?=$this->e($p_name)?>" value="1" <?=$l_checked?> /><?php   
    }
    
    function fileInput($p_name)
    {
        ?><input type='file' name='<?=$this->e($p_name)?>' /><?php    
    }
    
    function textAreaElement($p_name,$p_value,$p_css)
    {
        ?><textarea  name="<?=$this->e($p_name)?>" style="<?=$p_css?>"><?=$this->e($p_value)?></textarea><?php
    }
    
    function submitFooter()
    {
     ?></td></tr><?php   
    }
    
    
    function footer()
    {
        ?></table><?php    
    }
    
    function formFooter()
    {
        ?></form><?php    
    }
}