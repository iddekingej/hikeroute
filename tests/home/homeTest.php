<?php
use App\Http\Controllers\GuestController;

class homeTest extends \Tests\TestCase
{
    private $controller;
    function setup()
    {
        parent::setup();
        $this->controller=App::Make(GuestController::class);
    }
    function testRequestGuest()
    {        
        $this->controller->start();
    }
}