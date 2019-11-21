<?php

namespace App\Http\Controllers\Qq;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\QqFans;
use Illuminate\Support\Facades\Validator;

class Fans extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * 获取个人关注列表
         */
        //找到 id 对应的用户
        // $operating_user = $this->user()->id;
        // $data = QqFans::where('fans_id', $operating_user)
        //     ->get();
        
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
        /**
         * user_id 为当前被关注者id   fan_id为当前操作者的id
         */
        $rules = [
            'user_id' => 'required',
            'fans_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = QqArticle::create($request->all());

        return response()->json($data, 201);
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
        //传过来的参数为当前文章作者id
        //找到操作对应的用户
        $operating_user = $this->user()->id;
        //检查fans表中有无信息
        $data = QqFans::where('user_id', $id)
            ->where('fans_id', $operating_user)
            ->first();
        $record_id = $data->id;
        if (!$data) {
            QqFans::find($record_id)->delete();
            return response()->json(['messg' => 'Unfollow success'], 204);
        }
    }
}
