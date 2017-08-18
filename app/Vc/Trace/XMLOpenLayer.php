<?php
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Models\RouteTrace;

use XMLView\Widgets\Base\Widget;
use XMLView\Engine\Data\DynamicValue;
use XMLView\Engine\Data\DataStore;

class XMLOpenLayer extends Widget{
    /**
     * Route Trace displayed
     *
     * @var DynamicValue
     */
    private $routeTrace;
    private $id="map";
    private $icons=[];
    private $markers=[];
    
    function __construct(?RouteTrace $p_trace=null)
    {
        parent::__construct();
        $this->routeTrace=$p_trace;
        $this->setContainerHeight("0px");
    }
    
    function setTrace(DynamicValue $p_trace)
    {
        $this->routeTrace=$p_trace;
    }
    
    function getRouteTrace():?DynamicValue
    {
        return $this->routeTrace;
    }
    
    function getJs():array
    {
        return ["/js/ol.js"];
    }
    
    function getCss():array
    {
        return ["/css/ol.css"];
    }
    
    function addMarkers(String $p_icon,float $p_lat,float $p_lon)
    {
        $this->markers[]=[$p_icon,$p_lat,$p_lon];
    }
    
    function addIcon(string $p_name,string $p_url,int $p_sizeX,int $p_sizeY,int $p_offsetX,int $p_offsetY)
    {
        $this->icons[$p_name]=[$p_url,$p_sizeX,$p_sizeY,$p_offsetX,$p_offsetY];
    }
    
    
    
    
    function displayContent(DataStore $p_store):void
    {
        $l_routeTrace=$this->getAttValue("routeTrace", $p_store,RouteTrace::class,true);
        echo $this->theme->div()->id($this->id);
        ?>
		<script type='text/javascript'>
			var icons={};
        <?php
        
            if($this->icons){
                foreach($this->icons as $l_name=>$l_value){
                    ?>icons[<?=json_encode($l_name)?>]=new Openlayers.Icon(
                            <?=json_encode($l_value[0])?>,
                           new OpenLayers.Size(<?=json_encode($l_value[1])?>,<?=json_encode($l_value[2])?>),
                           new OpenLayer.Pixel(<?=json_encode($l_value[3])?>,<?=json_encode($l_value[4])?>)
                            );<?php 
                }
            } 
		?>
			l_map=new RouteMap(<?=json_encode($this->id)?>);
			l_map.setGpxRoute(<?=json_encode(Route("routes.download",["p_id"=>$l_routeTrace->id_routefile]))?>);
			l_map.setSize(<?=($l_routeTrace->minlat)?>,<?=($l_routeTrace->maxlat)?> , <?=($l_routeTrace->minlon)?> , <?=($l_routeTrace->maxlon)?>);
			l_map.displayMap();
		<?php 
		  if($this->markers){
		      ?>var l_markers= new OpenLayers.Layer.Markers("Markers");<?php 
              foreach($this->markers as $l_marker){
                  ?>l_markers.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(<?=json_encode($l_marker[1])?>,<?=json_encode($l_marker[2])?>)));                  
                  <?php 
                  
              }
		  }    
		?>
		</script>
		<?php
    }
}
