<?php 
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Models\RouteTrace;
use App\Vc\Lib\HtmlComponent;

class OpenLayer extends HtmlComponent{
    private $routeTrace;
    private $id="map";
    private $icons=[];
    private $markers=[];
    
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
    function getRouteTrace():RouteTrace
    {
        return $this->routeTrace;
    }
    
    function __construct(RouteTrace $p_trace)
    {
        $this->routeTrace=$p_trace;
        parent::__construct();
    }
    
    function display():void
    {
        
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
			l_map.setGpxRoute(<?=json_encode(Route("routes.download",["p_id"=>$this->routeTrace->id_routefile]))?>);
			l_map.setSize(<?=($this->routeTrace->minlat)?>,<?=($this->routeTrace->maxlat)?> , <?=($this->routeTrace->minlon)?> , <?=($this->routeTrace->maxlon)?>);
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
