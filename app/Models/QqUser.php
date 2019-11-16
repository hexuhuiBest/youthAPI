<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class QqUser extends Authenticatable implements JWTSubject
{
    protected $table = 'qq_users';
    
    protected $guarded = ['id'];

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
        return $this->hasMany('App\Models\QqArticle', 'user_id', 'id');
    }

    //关联评论模型 一个人评论过多篇文章  再根据评论找到对应文章展示出来
    public function QqComment() {
        return $this->hasMany('App\Models\QqComment', 'user_id', 'id');
    }
}
