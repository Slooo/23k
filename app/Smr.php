<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Smr extends Model
{
	protected $table = 'smr';
	protected $primaryKey = 'smr_id';
	public $incrementing = false;

	protected $fillable = [
		'smr_contractor_id',
	    'smr_location_id', 
	    'smr_type_equipment',
	    'smr_quantity',
	    'smr_published_at',
	];

}
