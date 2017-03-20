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
		$this->assertEqual($l_user->name,"bla123");
		$this->assertEqual($l_user->email,"bla123@xx.com");
		$this->assertEqual($l_user->password,bcrypt("test"));
		$this->assertEqual($l_user->firstname,"Afn");
		$this->assertEqual($l_user->lastname,"lnf");
	}
}