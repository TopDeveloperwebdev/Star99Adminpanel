<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class history extends Model
{
    //
    public $table = 'betlist_table';
    protected $fillable = [
        'id',
        'bet_date',
    ];
    protected $primaryKey = 'bet_date';
}
