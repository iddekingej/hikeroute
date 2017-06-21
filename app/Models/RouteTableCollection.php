<?php
declare(strict_types = 1);
namespace App\Models;

use App\Lib\TableCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class RouteTableCollection extends TableCollection
{

    protected static $model = Route::class;

    /**
     * Recalculate summary information of all routes
     * Called from command line with artisan
     */
    static function recalcAllGpx(): void
    {
        self::chunk(10, function ($p_routes) {
            foreach ($p_routes as $l_route) {
                try {
                    $l_route->recalcGpx();
                } catch (\Exception $e) {
                    echo "Route id=", $l_route->id, '-', $e->getMessage(), "\n";
                    echo $e->getTraceAsString(), "\n";
                }
            }
        });
    }

    /**
     * *
     * Full text search of all routes
     *
     * @param string $p_term            
     * @return Collection
     */
    static function search(string $p_term): Collection
    {
        $l_term = "%$p_term%";
        $l_qry = static::$model::orWhere(function ($p_query) use ($l_term) {
            $p_query->orWhere("title", "like", $l_term)
                ->orWhere("location", "like", $l_term)
                ->orWhere("comment", "like", $l_term);
        });
        return static::authQry($l_qry)->get();
    }

    /**
     * Add route authorization to a query on the route table
     *
     * @param Builder $p_query            
     * @return Builder
     */
    private static function authQry(Builder $p_query)
    {
        $l_qry = $p_query;
        if (\Auth::check()) {
            if (! \Auth::user()->isAdmin()) {
                $l_qry = $l_qry->orWhere(function ($p_qry) {
                    $p_qry->where("published", "=", 1);
                    $p_qry->where("id_user", "=", \Auth::user()->id);
                });
            }
        } else {
            $l_qry = $l_qry->where("publish", "=", 1);
        }
        return $l_qry;
    }

    /**
     * Get location and number of routes for a location with parent $p_id_parent
     *
     * @param int|null $p_id_parent
     *            Get all location with this parent. When null: get root parent
     * @return array
     */
    static function numRoutesByLocation(?int $p_id_parent): Array
    {
        $l_data = [];
        $l_qry = "select l.id,l.name,count(1) num from routes r join routetraces t on (r.id_routetrace=t.id) join tracelocations tl on(t.id=tl.id_routetrace) join locations l on (tl.id_location=l.id)  where";
        if ($p_id_parent === null) {
            $l_qry .= " l.id_parent is null";
        } else {
            $l_qry .= " l.id_parent=:id_parent";
            $l_data["id_parent"] = $p_id_parent;
        }
        $l_auth = "";
        if (\Auth::check()) {
            if (! \Auth::user()->isAdmin()) {
                $l_auth = "r.id_user=:id_user or r.publish=1";
                $l_data["id_user"] = \Auth::user()->id;
            }
        } else {
            $l_auth = "publish=1";
        }
        if ($l_auth) {
            $l_qry .= " and ($l_auth)";
        }
        $l_qry .= " group by l.id,l.name";
        return \DB::select(\DB::raw($l_qry), $l_data);
    }

    /**
     * Get all accessible routes by location
     *
     * @param int $p_id_location            
     * @return Collection
     */
    static function getAccessibleByLocation(int $p_id_location): Collection
    {
        $l_qry = self::$model::whereExists(function ($p_query) use ($p_id_location) {
            $p_query->select(\DB::raw(1))
                ->from("routetraces as rt")
                ->join("tracelocations as tl", "tl.id_routetrace", "=", "rt.id")
                ->whereRaw("rt.id=routes.id_routetrace")
                ->where("tl.id_location", "=", $p_id_location);
        });
        return static::authQry($l_qry)->get();
    }
    
    /**
     * Checks if an user has a route uploaded
     *
     * @param User $p_user
     *            The use to check of.
     * @return boolean true - user
     */
    static function userHasRoutes(User $p_user): bool
    {
        return !(self::where("id_user", "=", $p_user->id)->limit(1)
        ->get()
        ->isEmpty());
    }
}
?>