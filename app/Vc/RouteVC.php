<?php
declare(string_types = 1);
namespace App\Vc;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Route;
use App\Lib\Localize;

class RouteVC extends \App\Vc\ViewComponent
{

    /**
     * Display search input box
     */
    static function routeSearch(): void
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
    static function searchByLocation(Collection $p_tree, Array $p_locations): void
    {
        $l_pars = "";
        ?>
<div class="main_graybox">
	<div class="main_part_title"><?=__("Search by location")?></div>
	<div class="main_selected_locations"><?php static::link("/", __("World")) ?>
		<?php
        foreach ($p_tree as $l_location) {
            ?>
			&#187;&nbsp;<?php static::link("/location/$l_pars".$l_location->id,$l_location->name)?>
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
			<?php static::link("/location/$l_pars".$l_lrn->id,$l_lrn->name."(".$l_lrn->num.")");?>
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
    static function routeSummary(\App\Models\Route $p_route): void
    {
        ?>
<div class="routeall_title"><?=static::e($p_route->title)?></div>

<div class="routeall_body">
	<table class="routeall_infoTable">
		<tr>
			<td class="routeall_infoLabel"><?=static::e(__("Location"))?> </td>
			<td class="routeall_infoValue"><?=static::e($p_route->location)?> </td>
		</tr>
		<tr>
			<td class="routeall_infoLabel"><?=static::e(__("Added by"))?></td>
			<td class="routeall_infoValue"><?=static::e($p_route->user->name)?> </td>
		</tr>
	</table>
	<br />
		&nbsp;<?=static::linkRoute("display.overview",["id"=>$p_route->id], __("Goto route details"))?><br />
	
		<?=nl2br(static::e($p_route->comment))?>
	
		</div>
<?php
    }

    /**
     * Display summary information about some routes
     *
     * @param array $p_routes            
     */
    static function printRoutesSummary(Collection $p_routes): void
    {
        if (count($p_routes) > 0) {
            
            ?>
<div class="main_graybox">
	<div class="main_part_title"><?=__("Found routes")?></div>
			<?php
            
            foreach ($p_routes as $l_route) {
                static::routeSummary($l_route);
            }
            ?>
			</div>
<?php
        }
    }

  
}