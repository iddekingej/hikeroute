<?php
declare(strict_types = 1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{

    protected $table = "images";

    protected $fillable = [
        "image",
        "mimetype"
    ];

    function decodedImage()
    {
        return convert_uudecode($this->image);
    }
}  