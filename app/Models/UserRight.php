<?php
declare(strict_types = 1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRight extends Model
{

    protected $table = "user_rights";

    protected $fillable = [
        "id_right",
        "id_user"
    ];

    public $timestamps = false;

    /**
     * The user to which the UserRight belongs
     *
     * @return User
     */
    function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "id_user");
    }

    /**
     * Related right
     *
     * @return Right
     */
    function right(): BelongsTo
    {
        return $this->belongsTo(Right::class, "id_right");
    }


    /**
     * Grant a right to a user by adding a
     * record in the UserRight table
     *
     * @param \App\Models\User $p_user            
     * @param \App\Models\Right $p_right            
     * @return UserRight
     */
    static function addUserRight(User $p_user, Right $p_right): UserRight
    {
        return self::create([
            "id_user" => $p_user->id,
            "id_right" => $p_right->id
        ]);
    }
}
