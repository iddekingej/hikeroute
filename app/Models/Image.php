<?php
declare(strict_types = 1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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