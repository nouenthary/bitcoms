<?php


namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TransferCoin extends Model
{
    protected $table = 'tblcointranfer';

    protected $fillable = [
        'tranfercoinid',
        'fkuserid',
        'fkwalletid',
        'fromwalletname',
        'towalletname',
        'logofromwallet',
        'logotowallet',
        'amount',
        'timeupdate',
        'dateupdate',
        'amount_transfer',
        'exchange_price'
    ];

    public function user(){
        return $this->hasOne(UserModel::class,'userid','fkuserid');
    }

    public function wallet(){
        return $this->belongsTo(Wallet::class,'fkwalletid','walletid');
    }

    public $timestamps = false;
}
