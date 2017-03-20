<?php
use PHPUnit\Framework\TestCase;
use App\Models\User;
use Tests\CreatesApplication;
/**
 * CRUD action on user
 * 
 *
 */
class user1Test extends TestCase
{
	use CreatesApplication;
	
	private $user;
	function setUp(){
		$this->createApplication();
	}
	function testAddUser()
	{
		$l_user=User::create([
				'name'=>"bla123",
				'email'=>"bla123@xx.com", 
				'password'=>bcrypt("test"),
				"firstname"=>"Afn",
				"lastname"=>"Lnf"
			]);
		assertEqual($l_user->name,"bla123");
		assertEqual($l_user->email,"bla123@xx.com");
		assertEqual($l_user->password,bcrypt("test"));
		assertEqual($l_user->firstname,"Afn");
		assertEqual($l_user->lastname,"lnf");
	}
}