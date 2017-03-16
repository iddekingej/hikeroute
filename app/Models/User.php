<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
/**
 * Registered application users
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
        'name', 'email', 'password',"firstname","lastname"
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
     * Get the rights the user has
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function userRights()
    {
    	return $this->hasMany(UserRight::class,"id_user");
    }
    
    /**
     * Get the routes uploaded by the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function routes()
    {
    	return $this->hasMany(Route::class,"id_user");
    }
    /**
     * Check if the user has a right with a tag $p_tag (=kind of right)
     * 
     * @param String $p_tag
     * @return boolean
     */
    private function checkHasRight($p_tag)
    {    	
    	$l_userRights=$this->userRights();
    	foreach($l_userRights->get() as $l_userRight){
    		if($l_userRight->right()->getResults()->tag==$p_tag){
    			return true;
    		}
    	}
    	return false;
    }
    
    /**
     * Check if the user has admin rights
     * 
     * @return boolean true: user has admin rights, false:user has no admin rights
     */
    
    function isAdmin()
    {
    	if($this->isAdmin === null){
    		$this->isAdmin=$this->checkHasRight("admin");
    	}
    	return $this->isAdmin;
    }
    
    /**
     * Delete all the rights belonging to this user
     */
    function deleteRights()
    {	    	
   		\App\Models\UserRight::deleteUserRights($this->id);
    }
    
    /**
     * Check if we can delete the user
     * - If it has no postings
     * 
     * @return boolean true user can be deleted
     *                 false user can't be deleted
     */
    function canDelete()
    {
    	return Route::userHasRoutes($this);
    }
    
}
