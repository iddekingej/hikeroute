<?php
declare(string_types=1);
namespace App\Vc;
class RouteVC extends ViewComponent
{
	static function routeSearch()
	{
		?>
		
		<?=\Form::open(["route"=>["routes.search"]])?>
		<div class="main_search_container">
		<span><?=\Form::label("search",__("Search"))?></span><br/>
		<div class="main_search_input_container">
		<?=\Form::text("search","",["class"=>"main_search_input"]) ?>
		<?=\Form::submit(__("Search"))?>
		</div>
		</div>
		<?=\Form::close()?>
		<?php 
	}
}