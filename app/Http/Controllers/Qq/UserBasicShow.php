<?php

namespace App\Http\Controllers\Qq;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\QqArticle;
use App\Models\QqArticleGood;
use App\Models\QqComment;
use App\Models\QqFans;

class UserBasicShow extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * 获取个人发布动态总数
         * +个人关注用户总数
         * +个人评论总数
         * +个人赞过的文章总数
         * +个人获赞总数
         */
        //找到当前用户
        $operating_user = $this->user()->id;
        $dynamicTotal = QqArticle::where('user_id', $operating_user)
            ->count();
        $concernedTotal = QqFans::where('fans_id', $operating_user)
            ->count();
        $commentTotal = QqComment::where('user_id', $operating_user)
            ->count();
        $likeTotal = QqArticleGood::where('user_id', $operating_user)
            ->count();
        $articleData = QqArticle::where('user_id', $operating_user)->get();
        $praiseCount = 0;
        foreach ($articleData as $key => $value) {
            $articleId = $value->id;
            $perCount = QqArticleGood::where('id', $articleId)
                ->count();
            $praiseCount += $perCount;
        }
        
        return response()->json([
            'dynamicTotal' => $dynamicTotal,
            'concernedTotal' => $concernedTotal,
            'commentTotal' => $commentTotal,
            'likeTotal' => $likeTotal,
            'praiseCount' => $praiseCount
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
