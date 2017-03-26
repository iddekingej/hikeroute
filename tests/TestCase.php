<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    private $adminUser=false;
    function getResourcePath($p_name)
    {
    	return __DIR__."/resources/$p_name";
    }
    
    function getResource($p_name)
    {
    	return file_get_contents($this->getResourcePath($p_name));
    }
    
    function getResourceLen($p_name)
    {
    	return filesize($this->getResourcePath($p_name));
    }
    
    
    function getAdminUser()
    {
    	if($this->adminUser===false){
    		$this->adminUser=User::where("name","=","admin")->get()->first();
    	}
    	return $this->adminUser;
    }
    
    function loginToAdmin()
    {
    	\Auth::login($this->getAdminUser());
    }
    
    function setUp(){
    	$this->createApplication();
    	$this->loginToAdmin();
    }
}
