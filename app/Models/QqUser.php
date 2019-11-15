<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class QqUser extends Authenticatable implements JWTSubject
{
    protected $table = 'qq_users';
    protected $guarded = [
        'id',
        'qqapp_openid',
        'qqapp_session_key',
    ];

    protected $fillable = [
        'name',
        'school',
        'offical',
        'sex',
        'des',
        'tag',
        'level'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    //模型的关联操作：关联文章模型 （一对多）User -- Article
    public function QqArticle()
    {
        //第二参数为关联表字段，第三参数为本表关联字段   等号省略
        return $this->hasMany('App\Models\QqArticle', 'user_id', 'qqapp_openid');
    }
}
