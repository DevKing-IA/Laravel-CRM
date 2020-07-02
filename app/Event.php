<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable =[
        "start_time", "meeting","user_id"
    ];
}
