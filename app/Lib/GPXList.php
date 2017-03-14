<?php 
namespace App\Lib;

class GPXList{
	private $list=[];
	private $info;
	
	function __construct()
	{
		$this->info=new GPXInfo();
	}
	
	function addPoint($p_lat,$p_lon,$p_timestamp)
	{
		$this->list[]=new GPXPoint($p_lat, $p_lon,$p_timestamp);
		$this->info->update($p_lat,$p_lon);
	}
	
	
	
	function getList()
	{
		return $this->list;
	}
	
	function getStart()
	{
		return reset($this->list);
	}
	
	function getInfo()
	{
		return $this->info;
	}
}