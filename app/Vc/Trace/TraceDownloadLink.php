<?php 
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Models\RouteTrace;
use App\Vc\Lib\TextRouteLink;
/**
 * Download a route trace
*
 */
class TraceDownloadLink extends TextRouteLink{
    /**
     * Setup the link
     * 
     * @param RouteTrace $p_trace The route trace
     */
        
    function __construct(RouteTrace $p_trace)
    {        
        parent::__construct("traces.download", ["p_id"=>$p_trace->id], __("Download file"));
    }
    
}  