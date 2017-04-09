<?php
use App\Models\User;
use Tests\CreatesApplication;
use Tests\TestCase;

/**
 * CRUD action on user
 */
class user1Test extends TestCase
{
    use CreatesApplication;

    private $user;

    function testAddUser()
    {
        $l_password = bcrypt("test");
        $l_user = User::create([
            'name' => "bla123",
            'email' => "bla123@xx.com",
            'password' => $l_password,
            "firstname" => "Afn",
            "lastname" => "Lnf"
        ]);
        $this->assertEquals($l_user->name, "bla123");
        $this->assertEquals($l_user->email, "bla123@xx.com");
        $this->assertEquals($l_user->password, $l_password);
        $this->assertEquals($l_user->firstname, "Afn");
        $this->assertEquals($l_user->lastname, "Lnf");
    }

    function testGetUserRights()
    {
        $l_ur = $this->getAdminUser()->userRights();
        $this->assertNotNull($l_ur);
    }
}