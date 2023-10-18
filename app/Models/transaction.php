<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pumpid',
        'pump',
        'transaction',
        'state',
        'nozzle',
        'amount',
        'volume',
        'price',
        'tcvolume',
        'totalamount',
        'totalvolume',
        'userid',
        'status',
    ];
}
