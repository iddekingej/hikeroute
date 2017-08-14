<?php
namespace App\Vc\Lib\Cache;

class CacheType
{
    /**
     * No caching
     */
    
    static const CACHE_NONE=0;
    
    /**
     * Content of element is always the same
     */
    static const CACHE_STATIC=1;
    
    /**
     * Content can change and is depending on some unique ID
     */
    static const CACHE_DYNAMIC=2;
}