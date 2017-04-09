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
		&nbsp;<?=static::linkRoute("routes.display",["id"=>$p_route->id], __("Goto route details"))?><br />
	
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

    /**
     */
    static function routeInfoRow($p_label, $p_value, int $p_colSpanLabel = 1, int $p_colSpanValue = 1)
    {
        ?>
<td class="map_ud" colspan="<?=static::e((string)$p_colSpanLabel)?>">
				<?=static::e($p_label)?>
			</td>
<td class="map_ud_value"
	colspan="<?=static::e((string)$p_colSpanValue)?>">
				<?=static::e($p_value)?>
			</td>
<?php
    }

    static function routeInfo(Route $p_route)
    {
        ?>
<table>
	<tr>
		<?php
        static::routeInfoRow(__("Location"), $p_route->location, 1, 2);
        static::routeInfoRow(__("Distance"), Localize::meterToDistance($p_route->routeTrace->distance));
        ?>
		</tr>
	<tr>
		<?php
        static::routeInfoRow(__("Author"), $p_route->user->name, 1, 2);
        static::routeInfoRow(__("Crearted on"), \App\Lib\Localize::shortDate($p_route->created_at));
        ?>
		</tr>
	<tr>
		<td class="map_ud"><?=static::e(__("Download route"))?>:</td>
		<td colspan='4' class="map_ud_value"><?=RouteTracesVC::downloadLink($p_route->routeTrace)?></td>
	</tr>
</table>
<?php
    }
}