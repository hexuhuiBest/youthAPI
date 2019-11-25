<?php

namespace App\Transformers;

use App\Http\Controllers\Qq\Article;
use App\Models\Picture;
use App\Models\QqArticle;
use App\Models\QqArticleGood;
use App\Models\QqComment;
use App\Models\QqUser;
use Auth;
use Doctrine\DBAL\Schema\Schema;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    public function transform(QqArticle $article)
    {
        return [
            'id' => $article->id,
            'content'=>$article->content,
            'user_id'=>$this->users($article->user_id),
            'pictures' => $this->ImgTransformer($article->pictures),
            'count_comment'=>count(QqComment::where('article_id',$article->id)->get()),
            'count_zan'=>count(QqArticleGood::where('article_id',$article->id)->get()),
            'is_zan'=>is_null(QqArticleGood::where('article_id',$article->id)->where('user_id',$this->user()->id))?0:1
            ];
    }
    public function users($imga){
        $imga = QqUser::find($imga);
        return [
            'user_id'=>$imga->id,
            'nickname'=>$imga->nickName,
            'avatarUrl'=>$imga->avatarUrl
        ];
    }
    public function ImgTransformer($imga)
    {
        $array = [];
        if(!is_null($imga)) {
            foreach (json_decode($imga) as $key => $item) {
                $img = Picture::find($item);
                $imgs[$key] = $img->path;
            }
        }
        return $array;
    }
}