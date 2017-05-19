<?php 
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Models\RouteTrace;
use App\Vc\Lib\HtmlComponent;

class OpenLayer extends HtmlComponent{
    private $routeTrace;
    private $id="map";
    
    function getRouteTrace():RouteTrace
    {
        return $this->routeTrace;
    }
    
    function __construct(RouteTrace $p_trace)
    {
        $this->routeTrace=$p_trace;
        parent::__construct();
    }
    
    function display()
    {
        
        echo $this->theme->div()->id($this->id);
        ?>
		<script type='text/javascript'>
			l_map=new RouteMap(<?=json_encode($this->id)?>);
			l_map.setGpxRoute(<?=json_encode(Route("routes.download",["p_id"=>$this->routeTrace->id_routefile]))?>);
			l_map.setSize(<?=($this->routeTrace->minlat)?>,<?=($this->routeTrace->maxlat)?> , <?=($this->routeTrace->minlon)?> , <?=($this->routeTrace->maxlon)?>);
			l_map.displayMap();
		</script>
		<?php
    }
}

?>