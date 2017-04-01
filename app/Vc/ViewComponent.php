<?php 
declare(strict_types=1);
namespace App\Vc;

class ViewComponent
{
	/**
	 * HTML Escape string
	 *
	 * @param String $p_string
	 * @return string
	 */
	static function e($p_string):string
	{
		if($p_string===null){
			return "";
		}
		return htmlspecialchars($p_string,ENT_QUOTES|ENT_HTML5);
	}
	
	/**
	 * Make javascript for confirm message
	 *
	 * @param String Message in confirmation box
	 * @param String Url url location to go when confirmed
	 */
	static function confirmJs($p_message,$p_url)
	{
		return "if(confirm(".json_encode($p_message)."))window.location=".json_encode($p_url);
	}
	
	static function link(string $p_url,string $p_text):void
	{
		?><a href="<?=self::e($p_url)?>"><?=self::e($p_text)?></a><?php 
	}
	
	static function linkRoute(string $p_route,Array $p_data,string $p_text):void
	{
		self::link(Route($p_route,$p_data),$p_text);	
	}
}
?>