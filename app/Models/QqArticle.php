<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QqArticle extends Model
{
    protected $table = "qq_article";

    protected $guarded = ['id'];

    public $timestamps = false;

    //模型的关联操作：关联作者模型 （一对一）
    public function QqUserInfo() {
        //第二参数为关联表字段，第三参数为本表关联字段   等号省略
        return $this -> hasOne('App\Models\QqUserInfo', 'id', 'user_id');
    }

    public function Qqcomment() {
        return $this -> hasMany('App\Models\QqComment', 'article_id', 'id');
    }

}
