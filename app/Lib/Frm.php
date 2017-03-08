<?php
namespace App\Lib;

/**
 * Helper function for views
 *
 */

class Frm{
	
	static function checkBox($p_name,$p_label,$p_value)
	{
		?>
		<tr>
		<td class="form_labelCell">
		<?=\Form::label($p_name,$p_label)?>
		</td>
		<td class="form_elementCell">
		<?=\Form::checkbox($p_name,1,$p_value) ?>
		</td>
		</tr>
		<?php
	}
}
?>