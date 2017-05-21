<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteImage extends Model
{
    protected $table = "route_images";
    
    protected $fillable = [        
        "id_route",
        "id_image",
        "id_thumbnail",
        "position",
        "onsummary",
        "num_views"
    ];
    
    function incViews()
    {
        $this->increment("num_views");
    }
    
    
    function route():BelongsTo
    {
        return $this->belongsTo(Route::class,"id_route");
    }
    function image():BelongsTo
    {
        return $this->belongsTo(Image::class,"id_image");
    }
    
    function thumbnail():BelongsTo
    {
        return $this->belongsTo(Image::class,"id_thumbnail");
    }
    
    function deleteAll():void
    {
        $this->delete();
        $this->image->delete();        
    }
}
