<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Right is a table with rights
 * A user has one or more rights, this is stored in the 
 * user_rights table table.
 * "tag" is used to check for the 
 */

class Right extends Model
{
	protected $table="rights";
	protected $fillable = ["description","tag"];
	
	/**
	 * Table has no "timestamps"  rows (modification timestamps)
	 * @var boolean
	 */
	public    $timestamps = false;
}
