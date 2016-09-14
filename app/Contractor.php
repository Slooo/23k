<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    protected $table = 'contractor';
    protected $primaryKey = 'contractor_id';
    public $incrementing = false;
}
