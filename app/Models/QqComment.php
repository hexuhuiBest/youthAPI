<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QqComment extends Model
{
    protected $table = "qq_comment";

    protected $guarded = ['id'];
    
    public $timestamps = false;

     //模型的关联操作：关联文章模型 （一对一）一个评论对于一篇文章
     public function QqArticle() {
        return $this -> hasOne('App\Models\QqArticle', 'id', 'article_id');
    }
    
     //模型的关联操作：关联作者模型 （一对一）一个评论对应一个评论者
     public function Qquser() {
        return $this -> hasOne('App\Models\QqUser', 'id', 'user_id');
    }
}
