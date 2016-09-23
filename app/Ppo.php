<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ppo extends Model
{
	protected $table = 'ppo';
	protected $primaryKey = 'ppo_id';
	public $incrementing = false;
}
