<?php
namespace App\Lib;

class GPXLoadException extends \Exception
{
}

/**
 * Reads a gpx file and converts it to a GPXList object (A list of GPX points)
 */

class GPXReader
{
    /**
     * Converts a attribute $p_name of Node $p_node to a string value
     * 
     * @param \DOMNode $p_node  Node from which the attribute must be read.
     * @param String $p_name    name of the attribute
     * @return string|NULL		Value of the attribute or null when attribute doesn't exists   
     */
	private function getAttributeValue(\DOMNode $p_node,$p_name)
	{
		$l_node=$p_node->attributes->getNamedItem($p_name);
		if($l_node !==null){
			return $l_node->nodeValue;
		}
		return null;
	}

	private function parseTime(\DOMNode $p_parent)
	{
		$l_child=$p_parent->firstChild;
		while($l_child){
			if(($l_child->nodeType==XML_ELEMENT_NODE ) && ($l_child->nodeName=="time")){
					return $l_child->nodeValue;
			}
			$l_child=$l_child->nextSibling;
		}
		return "";
	}
	
	/**
	 * We search for gpx->trk->trkseg.
	 * This method searches trkseg for one or more trkpt node. These nodes are the 
	 * gpx points in the file. Information from those nodes are added to a list of type "GPXList.
	 * 
	 * @param \DOMNode $p_parent
	 * @throws \GPXLoadException
	 * @return \App\Lib\GPXList List of gpx points found in this file.
	 */
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
				$l_time=$this->parseTime($l_child);
				$l_return->addPoint($l_lat, $l_lon,$l_time);
			}
			$l_child=$l_child->nextSibling;
		}
		return $l_return;
	}

	/***
	 * Looking for a trkseg node under gpx=>trk node
	 * 
	 * @param \DOMNode $p_parent The trkseg node is search in the childeren of the trk node
	 * @return \App\Lib\GPXList List of GPX points found the this gpx file.
	 */
	
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
	
	/**
	 * The top node is a gpx node. This routine searches for a "trk" node under
	 * the GPX node
	 * 
	 * @param \DOMNode $p_parent The GPX node, the trk node is searched in child nodes of this node. 
	 * @return \App\Lib\GPXList Filled list with gpx points
	 */
	
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