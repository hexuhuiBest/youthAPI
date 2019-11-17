<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QqArticleGood extends Model
{
    protected $table = 'qq_article_good';

    protected $guarded = ['id'];

    //关联作者模型 （一对一）一个评论一名用户
    public function QqUserBasic() {
        return $this -> hasOne('App\Models\QqUserBasic', 'id', 'user_id');
    }

}
