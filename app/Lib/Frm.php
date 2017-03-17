<?php
namespace App\Lib;

/**
 * Helper function for views
 *
 */

class Frm{
	
	
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
}
?>