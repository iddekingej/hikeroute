<?php 
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Vc\Lib\TableVC;
use App\Lib\Localize;


class TraceTable extends TableVC
{
    private $route;
    private $params;
    function __construct($p_traces,string $p_route,Array $p_params)
    {
        parent::__construct($p_traces);
        $this->route=$p_route;
        $this->params=$p_params;
        $this->title=__("Route traces owned by user");
        $this->addConfig([
             "edit"=>["type"=>"@iconlink","icon"=>\App\Lib\Icons::EDIT,"title"=>""]
            ,"loc1"=>["type"=>"@text","title"=>""]
            ,"loc2"=>["type"=>"@text","title"=>""]
            ,"loc3"=>["type"=>"@text","title"=>""]
            ,"loc4"=>["type"=>"@text","title"=>""]
            ,"uploaddate"=>["type"=>"@text","title"=>__("Upload date")]
            ,"startdate"=>["type"=>"@text","title"=>__("Start date")]
            ,"distance"=>["type"=>"@text","title"=>__("Distance")]
        ]);
    }
    
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