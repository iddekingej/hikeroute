<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserRight extends Model
{
   protected $table="user_rights";
   protected $fillable = ["id_right","id_user"];
   public    $timestamps = false;
   
   /**
    * The user to which the UserRight belongs
    *  
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo 
    */
   
   function user()
   {
   		return $this->belongsTo(User::class,"id_user"); 
   }
   
   /**
    * Related right
    * 
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   
   function right()
   {
   		return $this->belongsTo(Right::class,"id_right")->getResults();
   }
   
   /**
    * Delete all the rights belonging to a user.
    *  
    * @param integer $p_id_user user id
    */
   
   static function deleteUserRights($p_id_user)
   {
   		DB::table("user_rights")->where("id_user","=",$p_id_user)->delete();   		
   }
      
   /**
    * Grant a right to a user by adding a 
    * record in the UserRight table
    * 
    * @param \App\Models\User $p_user 
    * @param \App\Models\Right $p_right
    * @return UserRight
    */
   
   static function addUserRight(User $p_user,Right $p_right)
   {
   		return self::create(["id_user"=>$p_user->id,"id_right"=>$p_right->id]);
   }
}
