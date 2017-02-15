<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
/**
 * Registered application user
 * From "users" table
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    private $isAdmin=null;
    /**
     * Get This rights the user has
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function userRights()
    {
    	return $this->hasMany('\App\UserRight',"id_user");
    }
    
    /**
     * Get the routes posted by the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function routes()
    {
    	return $this->hasMany("\App\Route","id_user");
    }
    
    /**
     * Check if the user is has admin rights
     * 
     * @return boolean true: user is has dmin rights, false:user has no admin rights
     */
    
    function isAdmin()
    {
    	if($this->isAdmin === null){
    		$this->isAdmin=false;
    		$l_userRights=$this->userRights();
    		foreach($l_userRights->get() as $l_userRight){
    			if($l_userRight->right()->getResults()->tag=="admin"){
    				$this->isAdmin=true;
    				break;
    			}
    		}
    	}
    	return $this->isAdmin;
    }
    
    /**
     * Delete all the rights belonging to this user
     */
    function deleteRights()
    {	    	
   		\App\UserRight::deleteUserRights($this->id);
    }
    
    /**
     * Check if we can delete the user
     * - If it has no postings
     * 
     * @return boolean true user can be deleted
     *                 false user can be deleted
     */
    function canDelete()
    {
    	return Route::userHasRoutes($this);
    }
    
}
