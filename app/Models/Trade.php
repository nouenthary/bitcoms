<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $table =  'tbltrde';

    protected $fillable = [
        'tradeid',
        'fkuserid',
        'feepercent',
        'feeamount',
        'amount',
        'totalamount',
        'namecurrency',
        'wintrade',
        'lastprice',
        'logocurrency',
        'timeupdate',
        'dateupdate',
        'timetrade',
        'tradetitle',
        'status'
    ];

    public $timestamps = false;
}