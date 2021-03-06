<?php
declare(strict_types = 1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TraceLocation extends Model
{

    protected $table = "tracelocations";

    protected $fillable = [
        "id_location",
        "id_routetrace",
        "position"
    ];

    /**
     * Get the RouteTrace to which the Trace location belongs to
     * 
     * @return RouteTrace
     */
    function routeTrace(): BelongsTo
    {
        return self::belongsTo(RouteTrace::class, "id_routetrace");
    }

    /**
     * Get location belonging to a route trace
     *
     * @return Location
     */
    function location(): BelongsTo
    {
        return self::belongsTo(Location::class, "id_location");
    }
}