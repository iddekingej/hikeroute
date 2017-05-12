<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Route;

use App\Vc\Lib\ThemeItem;
use App\Models\Route;
use Illuminate\Database\Eloquent\Collection;

class Search extends ThemeItem
{
    /**
     * Display search input box
     */
    function routeSearch(): void
    {
        ?>
		
		<?=\Form::open(["route"=>["routes.search"]])?>
		<div class="main_search_container">
			<span><?=\Form::label("search",__("Search"))?></span><br />
			<div class="main_search_input_container">
				<?=\Form::text("search","",["class"=>"main_search_input"]) ?>
				<?=\Form::submit(__("Search"))?>
			</div>
		</div>
		<?=\Form::close()?>
		<?php
    }

    /**
     * Select list of locations
     *
     * @param array $p_tree
     *            Current selected location
     * @param array $p_locations
     *            Location belonging to location selected location
     */
    function searchByLocation(Collection $p_tree, Array $p_locations): void
    {
        $l_pars = "";
        ?>
<div class="main_graybox">
	<div class="main_part_title"><?=__("Search by location")?></div>
	<div class="main_selected_locations"><?php $this->textLink("/", __("World")) ?>
		<?php
        foreach ($p_tree as $l_location) {
            ?>
			&#187;&nbsp;<?php $this->textLink("/location/$l_pars".$l_location->id,$l_location->name)?>
			<?php
            $l_pars .= $l_location->id . "/";
            ?>
		<?php
        }
        ?>
		</div>
		<?php
        foreach ($p_locations as $l_lrn) {
            ?>
			<div>
			<?php $this->textLink("/location/$l_pars".$l_lrn->id,$l_lrn->name."(".$l_lrn->num.")");?>
			</div>
		<?php }?>
		</div>
<?php
    }

    /**
     * Print summary information about a route
     *
     * @param \App\Models\Route $p_route            
     */
    function routeSummary(Route $p_route): void
    {
        ?>
<div class="routeall_title"><?=$this->e($p_route->title)?></div>

<div class="routeall_body">
	<table class="routeall_infoTable">
		<tr>
			<td class="routeall_infoLabel"><?=$this->e(__("Location"))?> </td>
			<td class="routeall_infoValue"><?=$this->e($p_route->location)?> </td>
		</tr>
		<tr>
			<td class="routeall_infoLabel"><?=$this->e(__("Added by"))?></td>
			<td class="routeall_infoValue"><?=$this->e($p_route->user->name)?> </td>
		</tr>
	</table>
	<br />
		&nbsp;<?=$this->textRouteLink("display.overview",["id"=>$p_route->id], __("Goto route details"))?><br />
	
		<?=nl2br($this->e($p_route->comment))?>
	
		</div>
<?php
    }
    
    function foundHeader()
    {
?>
<div class="main_graybox">
	<div class="main_part_title"><?=__("Found routes")?></div>
<?php
    }
    
    function foundFooter()
    {
?>
</div>
<?php
    }
}