<?php
namespace App\Lib;

class GPXInfo{
	public $minLon=null;
	public $maxLon=null;
	public $minLat=null;
	public $maxLat=null;
	
	function update($p_lat,$p_lon)
	{
		if($this->minLat==null){
			$this->minLat=$p_lat;
			$this->maxLat=$p_lat;
			$this->minLon=$p_lon;
			$this->maxLon=$p_lon;
		} else {
			if($this->minLon>$p_lon){
				$this->minLon=$p_lon;
			} else if($this->maxLon<$p_lon){
				$this->maxLon=$p_lon;
			}
			if($this->minLat>$p_lat){
				$this->minLat=$p_lat;
			} else if($this->maxLat < $p_lat){
				$this->maxLat=$p_lat;
			}
		}
	}

}