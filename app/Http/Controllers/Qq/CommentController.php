<?php

namespace App\Http\Controllers\Qq;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\QqArticle;

class CommentController extends Controller
{
    public function getPerArticleCom($id)
    {

        $data = QqArticleModel::where('id', $id)->get();

        foreach ($data as $key => $value) {

            $currentArticleId = $value->id;
            $currentArticleAuthor = $value->author->name;
            $currentArticle = $value->content;
            
            foreach ($value->comment as $k => $val) {
                $article_id = $val->id;
                $commentContent[$article_id] = $val->content;
                $commentpublisher[$article_id] = $val->author->name;
            }
        }

        return response()->json([
            "CurrentArticleInfo" => [
                'currentArticleId' => $currentArticleId,
                'currentArticleAuthor' => $currentArticleAuthor,
                'currentArticle' => $currentArticle
            ],
            'CurrentArticleCommentInfo' => [
                'commentContent' => $commentContent,
                'commentPublisher' => $commentpublisher
            ],
            "messge" => "Get Successfully"
        ], 200);
    }
}
