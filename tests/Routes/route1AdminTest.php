<?php 
require_once  "route1Base.php";

class Route1AdminTest extends \Tests\Routes\Route1Base
{
    function getTestUserName()
    {
        return static::USER_ADMIN;
    }
}