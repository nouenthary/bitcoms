<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $table = 'tblfee';
    protected $fillable = [
        'feeid',
        'tradeffeepercent',
        'widtrwfeepercent',
        'timeupdate',
        'dateupdate'
    ];

    public $timestamps = false;
}
