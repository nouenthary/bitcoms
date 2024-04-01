<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'tbldeposit';

    protected $fillable = [
        'depositid',
        'fkuserid',
        'fkwalletid',
        'namewallet',
        'qrimage',
        'walletaddr',
        'amout',
        'paymentvoucher',
        'status',
        'timeupdate',
        'dateupdate',
        'userconfirmid',
        'confirmtime',
        'confirmdate',
        'percent_fee',
        'total_fee'
    ];

    public $timestamps = false;
}
