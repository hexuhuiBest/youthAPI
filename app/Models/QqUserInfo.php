<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QqUserInfo extends Model
{
    protected $table = "users_info";
    // protected $fillable = [
    //     'name',
    //     'school',
    //     'qqapp_openid',
    //     'offical',
    //     'sex',
    //     'des',
    //     'tag',
    //     'level'
    // ];
    public $timestamps = false;
}
