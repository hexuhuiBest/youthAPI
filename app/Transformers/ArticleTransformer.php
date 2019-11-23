<?php

namespace App\Transformers;

use App\Http\Controllers\Qq\Article;
use App\Models\QqArticle;
use Doctrine\DBAL\Schema\Schema;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    public function transform(QqArticle $article)
    {
        return [
            'id' => $article->id,
            'content'=>$article->content,
            'user_id'=>$article->user_id,
            'pictures' => $this->ImgTransformer($article->pictures),
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