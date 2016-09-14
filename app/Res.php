<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Res extends Model
{
	protected $table = 'res';
	protected $primaryKey = 'res_id';
	public $incrementing = false;

	protected $fillable = [
	    'res_id', 
	    'pes', 
	    'res_name',
	    'pes_name',
	    'created_at',
	    'updated_at',
	];
}
