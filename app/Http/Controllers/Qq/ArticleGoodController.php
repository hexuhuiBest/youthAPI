<?php

namespace App\Http\Controllers\Qq;

use App\Models\QqArticleGood;
use Illuminate\Http\Request;


class ArticleGoodController extends Controller
{
    public function zan($id)
    {
        $article = QqArticleGood::where('article_id',$id)->first();
        if($article){
            $article = $article->delete();
            if($article){
                return $this->respond(1,'取消赞成功');
            }
        }else{
            $data = array([
                'user_id' => $this->user()->id,
                'article_id'=> $id,
                'comment_id'=>null,
            ]);
            $article = QqArticleGood::create($data);
            if($article){
                return $this->respond(1,'点赞成功');
            }
        }
    }
    protected function respond($code,$message,$data=null)
    {
        return $this->response->array([
            'code'=>$code,
            'data'=>$data,
            'message'=>$message
        ]);
    }
}
