<?php
namespace App\Lib;

/**
 * Helper function for views
 */
class Frm
{

    /**
     * HTML Escape string
     *
     * @param String $p_string
     * @return string
     */
    static function e($p_string): string
    {
        if ($p_string === null) {
            return "";
        }
        return htmlspecialchars("$p_string", ENT_QUOTES | ENT_HTML5);
    }
    
    
    static function error($p_name,$p_errors)
    {
		 if ($p_errors->has($p_name)){?>
			<div class="form_error"><?=$p_errors->first($p_name)?></div>
		<?php }
    }

    static function password($p_name, $p_label, $p_errors, $p_id, $p_style)
    {
        ?>
<tr id="<?=$p_id?>" style='<?=$p_style?>'>
	<td class="form_labelCell">
		<?=\Form::label($p_name,$p_label)?>
		</td>
	<td class="form_elementCell">
		<?php if ($p_errors->has($p_name)){?>
			<div class="form_error"><?=htmlspecialchars($p_errors->first($p_name))?></div>
		<?php }?>
			<?=\Form::password($p_name,["autocomplete"=>"off"])?>
			</td>
</tr>
<?php
    }

    static function text($p_name, $p_label, $p_value, $p_errors)
    {
        ?>
<tr>
	<td class="form_labelCell"> <?=\Form::label($p_name,$p_label);?></td>
	<td class="form_elementCell">
		<?php if ($p_errors->has($p_name)){?>
			<div class="form_error"><?=$p_errors->first($p_name); ?></div>
		<?php
        }
        echo \Form::text($p_name, $p_value, [
            "class" => "form_valueElement"
        ]);
        ?>
			</td>
</tr>
<?php
    }

    
    
    static function checkbox($p_name, $p_label, $p_value, Array $p_tags = null)
    {
        ?>
<tr>
	<td class="form_labelCell">
		<?=\Form::label($p_name,$p_label) ?>
		</td>
	<td class="form_elementCell">
		<?=\Form::checkBox($p_name,1,$p_value,$p_tags) ?>
		</td>
</tr>
<?php
    }

    static function email($p_name, $p_label, $p_value, $p_errors)
    {
        ?>
<tr>
	<td class="form_labelCell"> <?=\Form::label($p_name,$p_label)?></td>
	<td class="form_elementCell"> 
		<?php if ($p_errors->has($p_name)){?>
			<div class="form_error"><?=$p_errors->first($p_name)?></div>
		<?php }?>
		<?=\Form::email($p_name,$p_value,["class"=>"form_valueElement"])?>
	</td>
</tr>
<?php
    }
   
    static function file($p_name,$p_label,$p_errors)
    {
        ?>
        <tr>
        <?php  \Form::label($p_name,$p_label); ?>
        <td class="form_labelElement">
            <?php self::error($p_name,$p_errors);?>
            <?=\Form::file($p_name)?>
            </td>
            </tr>
           <?php
    }

    static function header($p_title,$p_submitRoute,Array $p_hidden){
        ?>
        <div class="form_body">
			<div class="form_container">
		<div class="form_title"><?=self::e($p_title)?></div><?php 
        echo \Form::open(["route"=>$p_submitRoute,"enctype"=>"multipart/form-data"]); 
        foreach($p_hidden as $l_key=>$l_value){
          echo \Form::hidden($l_key,$l_value);
        }            
        ?><table class="form_table"><?php 
        
    }
    static function submit($p_cancelUrl)
    {
        ?>
        <tr>
        <td colspan='2'><?=\Form::submit(__("Save"))?>
        	<button type='button'
                    onclick='window.location="<?=$p_cancelUrl?>"'><?=static::e(__("Cancel"))?></button>
         </td>
         </tr>
         </table>
         
        <?php
        \Form::close();
        ?>
        </div></div>
        <?php 
    }

    static function footer($p_cancelUrl)
    {
        $l_js = "window.location=" . json_encode(Route($p_cancelUrl));
        ?>
<tr>
	<td colspan='2' class="form_submitCell">
		<?=\Form::submit(__("Save")); ?>
		<button type='button' onclick='<?=htmlspecialchars($l_js)?>'><?=__("Cancel")?>'</button>
	</td>
</tr>
<?php
    }
}
?>