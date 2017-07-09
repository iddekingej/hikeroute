<?php 

use Tests\routes\Route1Base;

require_once "route1Base.php";

class Route1UserTest extends Route1Base
{
    function getTestUserName()
    {
        return static::USER_USER;
    }
}