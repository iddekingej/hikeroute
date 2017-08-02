<?php
declare(strict_types = 1);
namespace App\Models;

use App\Lib\TableCollection;

/**
 * Represents the UserRight table
 * @author jeroen
 *
 */
class UserRightTableCollection extends TableCollection
{

    protected static $model = UserRight::class;

    /**
     * Delete all the rights belonging to a user.
     *
     * @param User $p_user  All rights of this user is deleted
     *            
     */
    static function deleteUserRights(User $p_user)
    {
        static::where("id_user", "=", $p_user->id)->delete();
    }
}