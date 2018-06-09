<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    //
    protected $table = 'weather';

    /**
     * The storage format of the model's date columns
     * @var string
     */
    // 自动维护时间戳
    public $timestamps = false;


    protected $guarded = ['id'];

}
