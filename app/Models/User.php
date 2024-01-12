<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\receiptItems;
use App\Models\transactionBIR;
use DB;
// use Sofa\Eloquence\Eloquence;
// use Sofa\Eloquence\Mappable;
// use Sofa\Eloquence\Mutable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function activeTransaction(){
        $filtered = receiptItems::max('Transaction_ID');
        $data = receiptItems::where('Transaction_ID',$filtered)->get();
        return $data;
    }
    public function transactions(){
        $filtered = transactionBIR::max('Transaction_ID');
        $data = transactionBIR::where('Transaction_ID',$filtered)->get();
        return $data;
    }
    public function cashierRoles($id){

    }
}

