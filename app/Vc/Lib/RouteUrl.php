<?php 
use App\Lib\Base;
/**
 * Clas for handling routes urls. Combination of (route,parameters)
 * 
 *
 */
class RouteUrl extends Base
{
    private $route;
    private $params;
    
    function __construct(string $p_route,Array $p_params=[])
    {
        $this->route=$p_route;
        $this->params=$p_params;
    }
    
    function setParameter($p_name,$p_value){
        $this->params[$p_name]=$p_value;
    }
    
    function setParameters(array $p_value){
        foreach($p_value as $l_key=>$l_row) $this->params[$l_key]=$l_row;
    }
    
    function clone()
    {
        return new RouteUrl($p_route,$p_params);
    }
    
    function getUrl()
    {
        return Route($this->route,$this->params);
    }
    
    function __toString()
    {
        return $this->getUrl();
    }
}
