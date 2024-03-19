<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Withdrawal extends Model
{
    protected $table =  'tblwidtraw';

    protected $fillable = [
        'withdrawid',
        'fkuserid',
        'fkwalletid',
        'balance',
        'fee',
        'totalamount',
        'codeaddress',
        'codelink',
        'status',
        'createtime',
        'createdate',
        'confirmuserid',
        'confirmtime',
        'confirmdate',
        'feeamount'
    ];


    public function user(){
        return $this->hasOne(UserModel::class,'id','fkuserid');
    }

    public function wallet(){
        return $this->belongsTo(Wallet::class,'fkwalletid','walletid');
    }

    public $timestamps = false;
}
