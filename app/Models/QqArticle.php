<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QqArticle extends Model
{
    protected $table = "qq_article";

    protected $guarded = ['id'];

    public $timestamps = false;

    //模型的关联操作：关联作者模型 （一对一）一篇文章一个作者
    public function QqUser() {
        //第二参数为关联表字段，第三参数为本表关联字段   等号省略
        return $this -> hasOne('App\Models\QqUser', 'id', 'user_id');
    }

    //关联评论模型（一对多）一篇文章多个评论者
    public function Qqcomment() {
        return $this -> hasMany('App\Models\QqComment', 'article_id', 'id');
    }

}
