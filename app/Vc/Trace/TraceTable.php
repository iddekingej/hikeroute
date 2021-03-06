<?php 
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Vc\Lib\TableVC;
use App\Lib\Localize;
use App\Models\RouteTrace;


class TraceTable extends TableVC
{
    private $traces;
    private $route;
    private $params;
    
    function __construct($p_traces="",string $p_route="",Array $p_params=[])
    {
        parent::__construct($p_traces);
        
        $this->route=$p_route;
        $this->params=$p_params;
        $this->title=__("Route traces owned by user");

    }
    
    function setParams(Array $p_params)
    {
        $this->params=$p_params;
    }
    
    function getParams():Array
    {
        return $this->params;
    }
    
    /**
     * Set the route traces that are displayed in the table
     * 
     * @param unknown $p_traces List of RouteTrace objects
     */
    function setTraces($p_traces):void
    {
        $this->traces=$p_traces;
        $this->data=$p_traces;
    }
    
    /**
     * Get the route traces that are displayed in the list
     * 
     * @return unknown  Returns a list of RouteTrace objects
     */
    function getTraces()
    {
        return $this->traces;
    }
    /**
     * The user can select a trace. This method the the route part of the  
     * link of the selection element
     * 
     * @param string $p_route
     */
    function setRoute(string $p_route):void
    {
        $this->route=$p_route;
    }
    
    /**
     * The route part of the selection link
     * 
     * @return string
     */
    function getRoute():string
    {
        return $this->route;
    }
    
    /**
     * Setup the trace table definition
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\TableVC::setup()
     */
    function setup()
    {
        $this->addConfig([
            "edit"=>["type"=>static::ICONLINK,"icon"=>\App\Lib\Icons::EDIT,"title"=>""]
            ,"loc1"=>["type"=>static::TEXT,"title"=>""]
            ,"loc2"=>["type"=>static::TEXT,"title"=>""]
            ,"loc3"=>["type"=>static::TEXT,"title"=>""]
            ,"loc4"=>["type"=>static::TEXT,"title"=>""]
            ,"uploaddate"=>["type"=>static::TEXT,"title"=>__("Upload date")]
            ,"startdate"=>["type"=>static::TEXT,"title"=>__("Start date")]
            ,"distance"=>["type"=>static::TEXT,"title"=>__("Distance")]
        ]);
    }
    
    /**
     * Set the parameters of the selection routes
     * 
     * @param array $p_params
     */
    function setRouteParams(Array $p_params):void
    {
        $this->param=$p_params;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\TableVC::getData()
     */
    function getData($p_trace)
    {
        $l_params=$this->params;
        $l_params["id"]=$p_trace->id;
        return [
             "edit"=>Route( $this->route,$l_params)
            ,"loc1"=>$p_trace->getLocationByTypeCached("country")
            ,"loc2"=>$p_trace->getLocationByTypeCached("state")
            ,"loc3"=>$p_trace->getLocationByTypeCached("city")
            ,"loc4"=>$p_trace->getLocationByTypeCached("suburb")
            ,"uploaddate"=>Localize::longDate($p_trace->created_at)
            ,"startdate"=>Localize::shortDate($p_trace->startdate)
            ,"distance"=>Localize::meterToDistance((int)$p_trace->distance)
        ];
    }
}
?>