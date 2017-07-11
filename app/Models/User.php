<?php
declare(strict_types = 1);
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'name',
        'email',
        'password',
        "firstname",
        "lastname",
        "enabled"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    private $isAdmin = null;

    /**
     * Validate edit/add users request
     *
     * @param Request $p_request            
     * @param int $p_id            
     * @param bool $p_checkPassword            
     * @return unknown
     */
    static function validateRequest(Request $p_request, int $p_id, bool $p_checkPassword)
    {
        $l_rules = [
            "email" => [
                "required",
                "email",
                Rule::unique("users")->ignore($p_id)
            ],
            "name" => [
                "required",
                Rule::unique("users")->ignore($p_id)
            ],
            "firstname" => [
                "required"
            ],
            "lastname" => [
                "required"
            ]
        ];
        if ($p_checkPassword) {
            $l_rules["password"] = [
                "required"
            ];
            $l_rules["passwordconf"] = [
                "required",
                "same:password"
            ];
        }
        return Validator::make($p_request->all(), $l_rules);
    }

    /**
     * Delete user and right information
     */
    function deleteDepended()
    {
        $this->hasMany(UserRight::class, "id_user")->delete();
        $this->delete();
    }

    /**
     * Get the rights the user has
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function userRights(): HasMany
    {
        return $this->hasMany(UserRight::class, "id_user");
    }

    /**
     * Get the routes uploaded by the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function routes()
    {
        return $this->hasMany(Route::class, "id_user");
    }

    /**
     * Check if the user has a right with a tag $p_tag (=kind of right)
     *
     * @param String $p_tag            
     * @return boolean
     */
    private function checkHasRight($p_tag)
    {
        foreach ($this->userRights as $l_userRight) {
            if ($l_userRight->right->tag == $p_tag) {
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
        if ($this->isAdmin === null) {
            $this->isAdmin = $this->checkHasRight("admin");
        }
        return $this->isAdmin;
    }

    /**
     * Delete all the rights belonging to this user
     */
    function deleteRights()
    {
        UserRightTableCollection::deleteUserRights($this);
    }

    /**
     * Check if we can delete the user
     * - If it has no postings
     *
     * @return boolean true user can be deleted
     *         false user can't be deleted
     */
    function canDelete()
    {
        if(RouteTableCollection::userHasRoutes($this)){
            return false;
        }
        if(RouteTraceTableCollection::userHasRouteTraces($this)){
            return false;
        }
        return true;
    }
}
