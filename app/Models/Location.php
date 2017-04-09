<?php
declare(strict_types = 1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{

    protected $table = "locations";

    protected $fillable = [
        "id_locationtype",
        "id_parent",
        "name"
    ];

    /**
     * Get the parent location (e.g.
     * city=>state is parent location)
     * 
     * @return Location
     */
    function parentLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, "id_parent");
    }

    /**
     * Get the location type belonging to the location
     *
     * @return BelongsTo
     */
    function locationType(): BelongsTo
    {
        return $this->belongsTo(LocationType::class, "id_locationtype");
    }
}
