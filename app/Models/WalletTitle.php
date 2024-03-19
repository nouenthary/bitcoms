<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WalletTitle extends Model
{
    protected $table =  'tblwallettitle';

    protected $fillable = [
        'walletid',
        'namecurencywallet',
        'namecurency',
        'walletaddress',
        'qrimage',
        'imagecurency',
        'timeupdate',
        'dateupdate',
    ];

    public $timestamps = false;
}
