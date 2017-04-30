<?php
declare(strict_types = 1);
namespace App\Vc;

use App\Models\User;

class UserVC extends ViewComponent
{

    static private function profileRow($p_title, $p_value)
    {
        ?>
<tr>
	<td class="profile_label"><?=static::e($p_title)?></td>
	<td class="profile_value"><?=static::e($p_value)?></td>
</tr>
<?php
    }

    static function profile(User $p_user)
    {
        ?>
<div>		
		<?php
        \App\Lib\Frm::title(__("Profile"));
        ?>
		<table>		
		<?php
        
        static::profileRow(__("Nick name"), $p_user->name);
        static::profileRow(__("First name"), $p_user->firstname);
        static::profileRow(__("Last name"), $p_user->lastname);
        static::profileRow(__("Email address"), $p_user->email);
        ?>
		</table>
		<?php static::editLink("user.editprofile",[],__("Edit profile")) ?><br\>
		<?php static::editLink("user.editpassword",[],__("Edit password"))?>
</div>
<?php
    }
}
?>