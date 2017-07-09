<?php
declare(strict_types = 1);
namespace App\Models;
use \IMagick;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ImageException;

class Image extends Model
{

    protected $table = "images";

    protected $fillable = [
        "image",
        "mimetype"
    ];

    /**
     * Create IMagick object from image
     * 
     * @throws ImageException
     * @return IMagick
     */
    private function toIMImage():IMagick
    {
        $l_image=new IMagick();
        if(!$l_image->readImageBlob($this->decodedImage())){
            throw new ImageException("Reading image failed");
        }
        return $l_image;        
    }
    
  /**
   * Make thumbnail from image
   *  
   * @return \Imagick
   */
    function makeIMThumbnail():\Imagick
    {
        $l_image=$this->toIMImage();
        $l_image->resizeImage(80,180,0,1);
        return $l_image;
    }
   
    /**
     * Rotates image.
     * 
     * @param unknown $p_degrees
     * @throws ImageException
     */
    function rotate($p_degrees)
    {
        $l_image=$this->toIMImage();
        if(!$l_image->rotateImage(new \ImagickPixel(),$p_degrees)){
            throw new ImageException("Rotation failed");
        }
        $this->setImageIM($l_image);
    }
    
    /**
     * Set image by Imagick object
     * 
     * @param \Imagick $p_image
     */
    function setImageIM(\Imagick $p_image)
    {
        $this->setImage($p_image->getImageBlob());
    }
    
    /**
     * Set image with binairy  image data in string 
     * 
     * @param string $p_image
     */
    function setImage(string $p_image)
    {
        $this->image=convert_uuencode($p_image);
    }
    
    /**
     * Image is stored in the database as uuencoded string.
     * This method returns the raw binary image data by 
     * @return string
     */
    function decodedImage()
    {
        return convert_uudecode($this->image);
    }
}  