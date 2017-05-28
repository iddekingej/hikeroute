<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Vc\Lib\Form;
use App\Models\Route;
use App\Models\RouteTrace;
use Illuminate\Support\ViewErrorBag;

class RouteForm extends Form
{
    function __construct(?Route $p_route,RouteTrace $p_trace,ViewErrorBag $p_errors)
    {        
        if($p_route){
            $this->url=route("routes.save.edit",["id"=>$p_route->id,"id_routetrace"=>$p_trace->id]);
            $this->data["routeTitle"]=$p_route->title;
            $this->data["routeLocation"]=$p_route->location;
            $this->data["publish"]=$p_route->publish;
            $this->data["comment"]=$p_route->comment;
            $this->title=__("Edit route");
            $this->cancelUrl=Route("display.overview",["p_id_route"=>$p_route->id]);
        } else {
            $this->data["routeTitle"]="";
            $this->data["routeLocation"]="";
            $this->data["comment"]="";
            $this->data["publish"]=false;
            $this->url=route("routes.save.add",["id_routetrace"=>$p_trace->id]);
            $this->title=__("Add route");
            $this->cancelUrl=Route("routes");            
        }        
        parent::__construct($p_errors);
    }
    
    function setup()
    {
        $this->addElements([
            "routeTitle"=>["type"=>"@text","label"=>__("Title")]
            ,"routeLocation"=>["type"=>"@text","label"=>__("Location")]
            ,"publish"=>["type"=>"@checkbox","label"=>__("Publish")]
            ,"comment"=>["type"=>"@textarea","label"=>__("Comment")]            
        ]);
    }
}