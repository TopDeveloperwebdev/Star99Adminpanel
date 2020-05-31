<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    //
    public $table = 'players';
    protected $fillable = [
        'id',
        'created_at',
        'phone',
        'credits',
        'max_bet',
        'max_day',
        'status'
    ];
    protected $primaryKey = 'id';
}
