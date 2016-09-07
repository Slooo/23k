<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';
    protected $primaryKey = 'location_id';
    public $incrementing = false;

    protected $fillable = [
        'location_id', 
        'location_name', 
        'res_id',
        'contractor_id',
        'location_comment',
        'fiz18',
        'report_ppo',
        'schedule_plan',
        'trp',
        'estimate',
        'kc2',
        'created_at',
        'updated_at',
    ];
}