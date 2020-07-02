<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $fillable = ["name", "model", "identification", "driver_name", "capacity", "unit_id"];

    public function unit()
    {
    	return $this->belongsTo('App\Unit');
    }

    public function delivery()
    {
    	return $this->hasMany('App\Delivery');
    }
}
