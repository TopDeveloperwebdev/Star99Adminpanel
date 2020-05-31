<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bet_set extends Model
{
    //
    //
    public $table = 'setting_table';
    protected $fillable = [
        'id',
        'bet_type',
        'payout',
        'max_amount',
        'difference'
    ];
    protected $primaryKey = 'id';
}
