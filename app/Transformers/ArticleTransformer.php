<?php

namespace App\Transformers;

use App\Http\Controllers\Qq\Article;
use App\Models\Event;
use App\Models\Image;
use App\Models\Party;
use App\Models\Salvation;
use Doctrine\DBAL\Schema\Schema;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    public function transform(Article $article)
    {
        return [
            'id' => $article->id,
            'content'=>$article->content,
            'user_id'=>$article->user_id,
            'pictures' => $article->ImgTransformer($article->pictures),
            ];
    }

    public function ImgTransformer($imga)
    {
        $array = [];
        foreach (json_decode($imga) as $key=>$item){
            $img = Picture::find($item);
            $imgs[$key] = $img->path;
        }
        return $array;
    }
}