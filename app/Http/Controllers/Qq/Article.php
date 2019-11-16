<?php

namespace App\Http\Controllers\Qq;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\QqArticle;
use App\Models\QqUserInfo;
use App\Models\QqUser;
use Illuminate\Support\Facades\Validator;

class Article extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * 获取当前用户发布过的的所有文章       查
     */
    public function index()
    {
        //找到 id 对应的用户
        $id = $this->user()->id;
        //根据个人id查询个人信息    返回全部
        $perInfo = QqUser::where('id', $id)->get();
        $perId = $perInfo->id;
        $perName = $perInfo->name;
        $perSchool = $perInfo->school;
        $perTag = $perInfo->tags;
        $articleData = QqArticle::where('user_id', $perId)->get();

        return response()->json([
            "perInfo" => [
                "name" => $perName,
                "school" => $perSchool,
                'tag' => $perTag
            ],
            "articleData" => $articleData,
            "messge" => "Get Successfully"
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
    /**
     * 发布文章     增
     */
    public function store(Request $request)
    {
        $rules = [
            'content' => 'required|min:3',
            'user_id' => 'required',
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
    /**
     * 根据ID展示文章       查
     */
    public function show($id)
    {
        //根据id查询文章
        $data = QqArticle::find($id);
        if (is_null($data)) {
            return response()->json(["messg" => "Record not found"], 404);
        }

        return response()->json(QqArticle::find($id), 200);
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
    /**
     * 更新文章     改
     */
    public function update(Request $request, $id)
    {
        $judgePermissionResulit = judge($id);
        if ($judgePermissionResulit) {
            $data = QqArticle::find($id);
            $data->update($request->all());
            return response()->json($data, 200);
        } else {
            return response()->json(['errmessg' => 'Forbidden'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * 删除文章     删
     */
    public function destroy($id)
    {
        $judgePermissionResulit = judge($id);
        if ($judgePermissionResulit) {
            QqArticle::find($id)->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['errmessg' => 'Forbidden'], 403);
        }
    }

    public function judge($id)
    {
        //找到操作对应的用户
        $operating_user = $this->user()->id;
        //根据约束条件文章id 获取文章
        $data = QqArticle::find($id);

        if (is_null($data)) {
            return response()->json(["messg" => "Record not found"], 404);
        }
        //获取当前文章的发布者id  判断是否允许删除
        $cur_art_pub = $data->user_id;
        if ($operating_user == $cur_art_pub) {
            return true;
        } else {
            return false;
        }
    }
}
