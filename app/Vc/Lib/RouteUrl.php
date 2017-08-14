<?php 
use App\Lib\Base;
use Illuminate\Support\Facades\URL;
/**
 * Clas for handling routes urls. The route is build by using a route name and route parameters
 * 
 */
class RouteUrl extends Base
{
    /**
     * Route name used for the url.
     * @var string 
     */
    private $route;
    
    /**
     * Route parameters.
     * 
     * @var array
     */
    private $params;
    
    /**
     * Sets the route object.
     * 
     * @param string $p_route  The route name used in url.
     * @param array $p_params  The route parameters of url
     */
    function __construct(string $p_route,Array $p_params=[])
    {
        $this->route=$p_route;
        $this->params=$p_params;
    }

    /**
     * Set or overwrite parameters by a parameter name and value
     * The parameter property sets the route parameter, it has the same
     * function as the second parameter in the "route" function call
     * 
     */
    
    function setParameter($p_name,$p_value){
        $this->params[$p_name]=$p_value;
    }
    
    /**
     * Set or overwrite parameters by a associative array.
     * The parameter property sets the route parameter, it has the same
     * function as the second parameter in the "route" function call
     * 
     * @param array $p_parameters route parameters.
     */
    function setParameters(array $p_parameters){
        
        $this->params=array_merge($this->params,$p_parameters);
    }
    
    /**
     * Copy the Url
     * @return RouteUrl Deep copy of the route Url.
     */
    function clone()
    {
        return new RouteUrl($p_route,$p_params);
    }
    
    /**
     * Get the URL as string 
     * @return string The url.
     */
    function getUrl()
    {
        return Route($this->route,$this->params);
    }
    /**
     * Convert route to string 
     * @return string String Url
     */
    function __toString()
    {
        return $this->getUrl();
    }
}
