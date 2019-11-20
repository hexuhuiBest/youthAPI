<?php

namespace App\Http\Controllers\Qq;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserBasicShowController extends Controller
{
    /**
     * 该方法返回个人文章信息
     * +评论总数
     * +获赞总数
     */
    public function getPersonallyPublishedArticles() {
        $operating_user = $this->user()->id;
        $articleData = QqArticle::where('user_id', $operating_user)
        ->orderBy('id', 'DESC')
        ->get();

    }
}
