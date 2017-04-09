<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationType extends Model
{

    protected $table = "locationtypes";

    protected $fillable = [
        "sequence",
        "description"
    ];
}
