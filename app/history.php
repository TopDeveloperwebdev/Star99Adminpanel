<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class history extends Model
{
    //
    public $table = 'transaction_table';
    protected $fillable = [
        'id',
        'Date',
    ];
    protected $primaryKey = 'id';
}
