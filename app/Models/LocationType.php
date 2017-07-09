<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * LocationType model.
 * LocationType is the type of a location(city,country etc...)
 *
 */
class LocationType extends Model
{

    protected $table = "locationtypes";

    protected $fillable = [
        "sequence",
        "description"
    ];
}
