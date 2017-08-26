<?php
declare(strict_types = 1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteException extends \Exception
{

    function __construct($p_message, $p_previous = null)
    {
        return __construct($p_message, - 1, $p_previous);
    }
}

class Route extends Model
{

    protected $table = "routes";

    protected $fillable = [
        "id_user",
        "title",
        "comment",
        "location",
        "publish",
        "distance",
        "id_routetrace"
    ];

    /**
     * Get the user to which the route belongs to (=has posted)
     *
     * @return BelongsTo
     */
    function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "id_user");
    }

    /**
     * Contents of the route file
     *
     * @return BelongsTo
     */
    function routeTrace(): BelongsTo
    {
        return $this->belongsTo(RouteTrace::class, "id_routetrace");
    }

    function getRouteTrace()
    {
        return $this->routeTrace;
    }

    /**
     * Recalc data from gpx file,like min,max lat/lon and distance
     */
    function recalcGPX(): void
    {
        $l_routeTrace = $this->routeTrace;
        if ($l_routeTrace) {
            $l_routeTrace->recalcGPX();
        }
    }

    /**
     * TODO: move to RouteTbleCollection
     * 
     * Get published routes 
     * 
     * @return unknown
     */
    static function getPublished()
    {
        return self::where("publish", 1)->orderBy("id", "asc")->get();
    }

    /**
     * Delete route and all depended data
     * (RouteTrace and routeFile)
     */
    function deleteDepended(): void
    {
        foreach($this->routeImages as $l_image){            
            $l_image->deleteAll();
        }
        $this->delete();
        
    }

    /**
     * Has the current enough rights to display route
     *
     * @return bool true Current user has display rights to route
     *         false Current user has can't view to route
     *        
     */
    function canCurrentShow(): bool
    {
        if ($this->publish == 1) {
            return true;
        }
        if (\Auth::check()) {
            return $this->canShow(\Auth::user());
        }
        return false;
    }

    /**
     * Checks if user can view route
     *
     * @param \App\Models\User $p_user            
     * @return bool
     */
    function canShow(?User $p_user): bool
    {
        if($this->publish){
            return true;
        }
       if($p_user){
            if ($p_user->isAdmin()) {
                return true;
            }
            if ($this->id_user == $p_user->id) {
                return true;
            }
        }
        return false;
    }
/**
 * Checks if the user can edit the route
 * 
 * @param User $p_user User to check for
 * @return bool   true - user can edit the route false- user can't edit the route
 */
    function canEdit(?User $p_user): bool
    {
        if($p_user===null){
            return false;
        }
        if ($p_user->isAdmin()) {
            return true;
        }
        return $this->id_user == $p_user->id;
    }
    
/**
 * Records from the 'RouteImage' table that belongs to the route
 * 
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */    
    function routeImages()
    {
        return $this->hasMany(RouteImage::class,"id_route");
    }
    
/**
 * Checks if the route has images
 * @return true - route has images false - route has no images
 */   
    function hasImages()
    {
        return RouteImage::where("id_route", $this->id)->exists();        
    }
    
/**
 * Get the images that are published at the summary page of the route (onsummary=1)
 * @return unknown
 */
    function summaryImages()
    {
        return $this->routeImages()->where("onsummary","=",1)->orderby("position");   
    }
   
}