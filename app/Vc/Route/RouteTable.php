<?php
declare(strict_types=1);
namespace App\Vc\Route;

use App\Vc\Lib\TableVC;
/**
 * This is a table with information about routes
 *
 */
class RouteTable extends TableVC
{
    /**
     * setup the list of routes to display.
     * This list contains the follwing information
     * - Title      : route title
     * - createdate : On which date the route was added.
     * - startdate  : Start date of the GPX trace
     * - distance   : length of route
     * - publish    : flag that indicates if the route is published at the fron page
     * 
     * @param unknown $p_routes List of routes to display
     */
    function __construct($p_routes)
    {
        parent::__construct($p_routes);
        $this->addConfig([
           "title"=>["type"=>"@link","title"=>__("Title")]
          ,"createdate"=>["type"=>"@text","title"=>__("Create date")]
          ,"startdate"=>["type"=>"@text","title"=>__("Start date")]
          ,"distance"=>["type"=>"@text","title"=>__("Distance")]
          ,"publish"=>["type"=>"@text","title"=>__("Publish")]
        ]);
        $this->title=__("Routes overview");
    }
    /**     
     * {@inheritDoc}
     * @see \App\Vc\Lib\TableVC::getData()
     */
    function getData($p_item)
    {
        $l_trace=$p_item->routeTrace;
        return [
            "title"=>[Route('display.overview',['id'=>$p_item->id]),$p_item->title]
            ,"createdate"=>\App\Lib\Localize::shortDate($p_item->created_at)
            ,"startdate"=>\App\Lib\Localize::shortDate($l_trace->startdate)
            ,"distance"=>\App\Lib\Localize::meterToDistance((int)$l_trace->distance)
            ,"publish"=> $p_item->publish?__("Yes"):""
        ];
    }
}
