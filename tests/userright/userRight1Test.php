<?php
use Tests\TestCase;
use App\Models\UserRight;
use App\Models\Right;
use App\Models\User;

/**
 * CRUD action on user
 */
class userRight1Test extends TestCase
{

    private $all;

    function setUp()
    {
        parent::setup();
        $this->all = UserRight::all();
    }

    function testNotEmpty()
    {
        $this->assertEquals(false, $this->all->isEmpty());
    }

    function testRelationsRight()
    {
        $l_first = $this->all->first();
        $l_right = $l_first->right;
        $this->assertInstanceOf(Right::class, $l_right);
    }

    function testRelationsUser()
    {
        $l_first = $this->all->first();
        $l_right = $l_first->user;
        $this->assertInstanceOf(User::class, $l_right);
    }
}