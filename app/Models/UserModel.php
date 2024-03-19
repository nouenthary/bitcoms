<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table =  'users';

    protected $hidden =  [
        'password'
    ];

    public function withdrawal(){
        return $this->belongsTo(Withdrawal::class,'fkuserid','id');
    }

    public function transferCoin(){
        return $this->belongsTo(TransferCoin::class,'fkuserid','id');
    }

    public $timestamps = false;
}
