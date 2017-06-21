<?php
declare(strict_types=1);
namespace App\Vc\Lib;

abstract class MenuItem extends HtmlComponent
{
    private $tag;
    
    function __construct(string $p_tag)
    {
        $this->tag=$p_tag;
        parent::__construct();
    }
    
    function getTag():string
    {
        return $this->tag;
    }
}