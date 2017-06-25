<?php
namespace Tests;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class TestSession extends Session
{
    protected $privateStorage;
    
    function __construct()
    {
        $this->privateStorage=new NativeSessionStorage();
        parent::__construct($this->privateStorage);
    }
    
    function hasOldInput($p_key)
    {
        return false;
    }
    
    function getOldInput($p_key)
    {
        return null;        
    }
}