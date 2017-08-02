<?php
declare(strict_types = 1);
namespace App\Location;

/**
 * Converts GPS location to description by query a OpenStreetMap database directly
 * This query uses PostGis and a local Postgres OpenStreetMap database.
 */

class LocationQueryDB implements LocationQueryService
{
    /**
     * Converts location to coordinates used in databases
     * By default it's from GPS to Mercator projection.
     * Note:Normally, it is not necessary to change the default configuration
     *  
     * @var integer
     */
    
    private $sridSource = 4326; //WGS 84 GPS based coordinates
    
    /**
     * See $sridSource
     * 
     * @var integer
     */
    private $sridDest   = 3857; //Mercator projection
    
    
    /**
     * Service config
     *
     * @var Array
     */
    
    private $config;
    
    /**
     * Admin_levels from table planet_osm_polygon used in query
     * 
     * @var Array
     */
    private $adminLevels=[
        "2" => "country",
        "4" => "state",
        "8" => "city",
        "10" => "suburb"
    ];

    /**
     * Cached query used for query the location
     * 
     * @var string
     */
    private $cachedQuery=null;

    /**
     * Cache of some of the parameters used in query
     * 
     * @var Array
     */
    
    private $cachedAlParams=null;
    
    /**
     * Constructor.
     * Sets the configuration data:
     * 
     * $p_config["connection"] : (mandatory) Database connection string
     * $p_config["adminlevel"] : (optional)  adminLevel configuration
     * 
     * @param array $p_config
     */
    
    function __construct(Array $p_config)
    {
        $this->config = $p_config;
        
        if(isset($p_config["adminLevels"])){
            $this->adminLevels = $p_config["adminLevels"];
        }
    }

    /**
     * Sets sridSource and sridDest
     * Note:Normally, it is not necessary to change the default configuration
     * 
     * @param unknown $p_source
     * @param unknown $p_destination
     */
    
    function setSRID(int $p_source,int $p_destination):void
    {
        $this->sridSource=$p_source;
        $this->sridDest  =$p_destination;
    }
    
 
    /**
     * Make query string and parameter array and cache it.
     * 
     * @param string $p_cachedQuery
     * @param Array $p_alParams
     */
    private function makeAlCache(&$p_cachedQuery,&$p_alParams):void
    {
        
        if($this->cachedQuery === null){
            $l_bind="";
            $this->cachedAlParams = [];
            
            foreach($this->adminLevels as $l_level=>$l_dummy){
                if($l_bind != ""){
                    $l_bind .= ",";
                }
                $l_param="v".$l_level;
                $l_bind .= ":$l_param";
                $this->cachedAlParams[$l_param] = $l_level;
            }
            $this->cachedQuery="select admin_level,name from planet_osm_polygon where ST_CONTAINS(way,ST_TRANSFORM(ST_GeomFromText('point('||:lon||' '||:lat||')',:sridSource),:sridDest)) and (admin_level in ($l_bind))";
        }
        
        $p_cachedQuery = $this->cachedQuery;
        $p_alParams = $this->cachedAlParams;
    }
    
    /**
     * Returns location name by GPS location
     * result->address is a object, with fields defined in "adminLevel"
     * Example: result->address->country="Netherlands", result->address->city="Amsterdam"
     * 
     * @see \App\Location\LocationQueryService::query()
     */
    
    function query(float $p_lat, float $p_lon):?LocationResult
    {
        $l_connection = $this->config["connection"];
        
        $l_cachedQuery = null;
        $l_alParams    = null;
        
        $this->makeAlCache($l_cachedQuery,$l_alParams);
        
        $l_params = $l_alParams;
        $l_params["lon"] = $p_lon;
        $l_params["lat"] = $p_lat;
        $l_params["sridSource"] = $this->sridSource;
        $l_params["sridDest"]   = $this->sridDest;

        $l_locations = \DB::connection($l_connection)->select(\DB::raw($l_cachedQuery) , $l_params);

        $l_address = new LocationResult();
        foreach ($l_locations as $l_location) {
            $l_name = $this->adminLevels[$l_location->admin_level];
            $l_address->addLocation($l_name,$l_location->name);
        }
        
        return $l_address;
    }
}