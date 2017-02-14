<?php 
namespace App\Lib;

class GPXList{
	private $list=[];
	private $info;
	
	function __construct()
	{
		$this->info=new GPXInfo();
	}
	
	function addPoint($p_lat,$p_lon)
	{
		$this->list[]=new GPXPoint($p_lat, $p_lon);
		$this->info->update($p_lat,$p_lon);
	}
	
	function getInfo()
	{
		return $this->info;
	}
}