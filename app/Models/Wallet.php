<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table =  'tblwallet';

    protected $fillable = [
        'walletid',
        'fkuserid',
        'fkwallettileid',
        'balance',
        'createtime',
        'createdate',
        'codeaddres',
        'codelink'
    ];

    public function withdrawal(){
        return $this->belongsTo(Withdrawal::class,'fkwalletid','fkwalletid');
    }

    public function transferCoin(){
        return $this->belongsTo(TransferCoin::class,'fkwalletid','walletid');
    }

    public $timestamps = false;
}
