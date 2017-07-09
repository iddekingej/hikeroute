<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/**
 * 
 * Images belgonging to a route 
 *
 */
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
    
    /**
     * Increment the number of views of a image
     */
    
    function incViews()
    {
        $this->increment("num_views");
    }
    
    /**
     * Get the route to which the RouteImage belongs
     * 
     * @return BelongsTo
     */
    function route():BelongsTo
    {
        return $this->belongsTo(Route::class,"id_route");
    }
    
    /**
     * Get the image Model
     * @return BelongsTo
     */
    function image():BelongsTo
    {
        return $this->belongsTo(Image::class,"id_image");
    }
    
    /**
     * Get the thumbnail version
     * @return BelongsTo
     */
    function thumbnail():BelongsTo
    {
        return $this->belongsTo(Image::class,"id_thumbnail");
    }
    
    /**
     * Delete This record and also the image data
     * TODO: Delete thum
     */
    function deleteAll():void
    {
        $this->delete();
        $this->image->delete();        
    }
}
