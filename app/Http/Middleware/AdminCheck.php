<?php 
namespace App\Http\Middleware;

use Closure;
use App\Lib\Base;

class AdminCheck extends Base
{
    public function handle($p_request,Closure $p_next)
    {
        if (! \Auth::user()->isAdmin()) {
            return View("other.error", [
                    "message" => __("Not authorized")
            ]);
        } 
        return $p_next($p_request);
    }
}