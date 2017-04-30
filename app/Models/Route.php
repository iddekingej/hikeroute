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

    function canEdit(?User $p_user): bool
    {
        if ($p_user->isAdmin()) {
            return true;
        }
        return $this->id_user == $p_user->id;
    }
    
    function routeImages()
    {
        return $this->hasMany(RouteImage::class,"id_route");
    }
}