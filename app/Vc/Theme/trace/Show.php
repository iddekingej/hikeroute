<?php 
declare(strict_types=1);
namespace App\Vc\Theme\trace;

use App\Vc\Lib\ThemeItem;

class Show extends ThemeItem
{
    function container()
    {
        ?><div class="map_container"><?php 
        
    }
    function infoHeader()
    {
        ?>
        <table class="map_table">
        <tr>
        <td>
        <?php 
    }
    
    function mapHeader()
    {
        ?>
        </td>
        </tr>
        <tr>
        <td>
        <?php 
    }
    
    function mapFooter()
    {
?>
	</td>
</tr>
</table>
</div>
<?php 
    }
}