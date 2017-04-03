<?php 
declare(strict_types=1);

namespace App\Lib;

class GPXList{
	private $list=[];
	private $info;
	
	function __construct()
	{
		$this->info=new GPXInfo();
	}
	
	function addPoint(float $p_lat,float $p_lon,string $p_timestamp)
	{
		$this->list[]=new GPXPoint($p_lat, $p_lon,$p_timestamp);
		$this->info->update($p_lat,$p_lon);
	}
	
	
	
	function getList():Array
	{
		return $this->list;
	}
	
	function getStart():GPXPoint
	{
		return reset($this->list);
	}
	
	function getInfo()
	{
		return $this->info;
	}
}