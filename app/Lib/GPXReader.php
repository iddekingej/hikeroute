<?php
namespace App\Lib;

class GPXLoadException extends \Exception
{
}



class GPXReader
{

	private function getAttributeValue(\DOMNode $p_node,$p_name)
	{
		$l_node=$p_node->attributes->getNamedItem($p_name);
		if($l_node !==null){
			return $l_node->nodeValue;
		}
		return null;
	}

	private function parsePoints(\DOMNode $p_parent)
	{
		$l_child=$p_parent->firstChild;
		$l_return=new GPXList();
		
		while($l_child){			
			if(($l_child->nodeType==XML_ELEMENT_NODE ) && ($l_child->nodeName=="trkpt")){
				$l_lat=$this->getAttributeValue($l_child,"lat");
				if($l_lat===null){
					throw new \GPXLoadException("'lat' attribute not found at trkpt node");
				}
				$l_lon=$this->getAttributeValue($l_child,"lon");
				if($l_lon===null){
					throw new \GPXLoadException("'lon' attribute not found at trkpt node");
				}
				$l_return->addPoint($l_lat, $l_lon);
			}
			$l_child=$l_child->nextSibling;
		}
		return $l_return;
	}

	private function parseTrkSeg(\DOMNode $p_parent)
	{
		$l_child=$p_parent->firstChild;
		while($l_child){			
			if(($l_child->nodeType==XML_ELEMENT_NODE) && ($l_child->nodeName=="trkseg")){
				return $this->parsePoints($l_child);
			}
			$l_child=$l_child->nextSibling;
		}
		throw new GPXLoadException("trkseg under trk not found");
	}
	
	private function parseTrk(\DOMNode $p_parent)
	{
		$l_child=$p_parent->firstChild;
		
		while($l_child){					
			if(($l_child->nodeType==XML_ELEMENT_NODE) && ($l_child->nodeName=="trk")){
				return $this->parseTrkSeg($l_child);				
			}
			$l_child=$l_child->nextSibling;
		}
		throw new GPXLoadException("TRK node under GPX not found");
	}
	
	function parse($p_data) 
	{
		$l_dom=new \DOMDocument();
		$l_dom->loadXML($p_data);
		$l_element=$l_dom->documentElement;
		$l_element->normalize();
		if($l_element->nodeName=="gpx"){
			return $this->parseTrk($l_element);
		}else {
			throw new GpxLoadError("GPX file doesn't start with a gpx tag");
		}
	}

}