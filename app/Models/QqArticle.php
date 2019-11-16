<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QqArticle extends Model
{
    protected $table = "qq_article";

    protected $guarded = ['id'];

    public $timestamps = false;

    //关联作者模型 （一对一）一篇文章一位作者
    public function QqUser() {
        return $this -> hasOne('App\Models\QqUser', 'id', 'user_id');
    }

    //关联评论模型（一对多）一篇文章多个评论
    public function QqComment() {
        return $this -> hasMany('App\Models\QqComment', 'article_id', 'id');
    }

}
