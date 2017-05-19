<?php 
declare(strict_types=1);
namespace App\Vc\Theme\user;

use App\Vc\Lib\ThemeItem;

class Profile extends ThemeItem
{
    
    function profileHeader()
    {
        ?>
<div>		
		<?php
        \App\Lib\Frm::title(__("Profile"));
        ?>
<table>		
<?php
    }

    function profileRow($p_title, $p_value)
    {
        ?>
<tr>
	<td class="profile_label"><?=$this->e($p_title)?></td>
	<td class="profile_value"><?=$this->e($p_value)?></td>
</tr>
<?php
    }
    
    function profileEnd()
    {
?></table><?php 
    }
    
    function profileFooter()
    {
?></div><?php 
    }
}