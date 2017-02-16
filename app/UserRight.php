<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserRight extends Model
{
   protected $table="user_rights";
   protected $fillable = ["id_right","id_user"];
   public    $timestamps = false;
   
   function user()
   {
   		return $this->belongsTo(\App\User::class,"id_user"); 
   }
   
   function right()
   {
   		return $this->belongsTo(\App\Right::class,"id_right");
   }
   
   static function deleteUserRights($p_id_user)
   {
   		DB::table("user_rights")->where("id_user","=",$p_id_user)->delete();   		
   }
      
   static function addUserRight(\App\User $p_user,\App\Right $p_right)
   {
   		return self::create(["id_user"=>$p_user->id,"id_right"=>$p_right->id]);
   }
}
