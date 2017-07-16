<?php
namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Session\Store;


/**
 * 
 * Test case base class
 *
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    const TRACE1 = "2_nov._2016_09_01_26.gpx";
    const TRACE2 = "2_nov._2016_10_24_21.gpx";
    const TRACE3 = "10_sep._2016_14_00_02.gpx";
    const IMG1_JPEG= "DSC02062.JPG";
    const IMG1_JPEG_TMP="DSC02062.XXX";
    const USER_ADMIN="admin";
    const USER_USER="user";
    private $adminUser = false;
    protected $store;
    protected $session;
    
    /**
     * Get test resources (file) path
     * @param string $p_name name of resources (relative to the resource folder)
     * @return string
     */
    function getResourcePath($p_name)
    {
        return __DIR__ . "/resources/$p_name";
    }
    /**
     * Get test resources (file) content
     * @param string $p_name name of resources (relative to the resource folder)
     * @return string
     */
    function getResource($p_name)
    {
        $l_content=file_get_contents($this->getResourcePath($p_name));
        if($l_content===false){
            throw new \Exception("Resource $p_name not found");
        }
        
        return $l_content;
    }

    /**
     * Get test resources (file) size
     * @param string $p_name name of resources (relative to the resource folder)
     * @return string
     */
    function getResourceLen($p_name)
    {
        return filesize($this->getResourcePath($p_name));
    }

    function getTestUserName()
    {
        return static::USER_ADMIN;
    }
    
    function getAdminUser()
    {
        if ($this->adminUser === false) {
            $this->adminUser = User::where("name", "=", $this->getTestUserName())->get()->first();
        }
        return $this->adminUser;
    }

    function loginToAdmin()
    {
        \Auth::login($this->getAdminUser());        
    }
    
    function routeRegexStr($p_route,Array $p_params)
    {
        return "/".str_replace("/","\\/",Route($p_route,$p_params))."/";
    }
    
    function outputContainsRoute($p_routes){
        $l_output=$this->getActualOutput();
        foreach($p_routes as $l_route){
            $l_expect=Route($l_route[0],$l_route[1]);
            $this->assertContains($l_expect, $l_output);
        }
    }

    function setUp()
    {
        parent::setup();
        $this->createApplication();
        $l_store=new TestSession();
        app("request")->setSession($l_store);
        $this->loginToAdmin();
    }
}
