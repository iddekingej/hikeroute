<?php
namespace App\Lib;

/**
 * Helper function for views
 *
 */

class Frm{
	
	static function e(string $p_string):string
	{
		return \App\Lib\Page::e($p_string);
	}
	
	static function title(string $p_title):void
	{
		?><div class="form_title"><?=static::e($p_title)?></div><?php 
	}
	
	
	static function password($p_name,$p_label,$p_errors,$p_id,$p_style)
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
	
	static function text($p_name,$p_label,$p_value,$p_errors)
	{
		?>
		<tr>
		<td class="form_labelCell"> <?=\Form::label($p_name,$p_label);?></td>
		<td class="form_elementCell">
		<?php if ($p_errors->has($p_name)){?>
			<div class="form_error"><?=$p_errors->first($p_name); ?></div>
		<?php 		
		}
			echo \Form::text($p_name,$p_value,["class"=>"form_valueElement"]);
		?>
			</td>
		</tr>
		<?php 
	}
	
	static function checkbox($p_name,$p_label,$p_value,Array $p_tags=null)
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
	
	static function email($p_name,$p_label,$p_value,$p_errors)
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
	
	static function footer($p_cancelUrl)
	{
		$l_js="window.location=".json_encode(Route($p_cancelUrl));
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