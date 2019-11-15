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
        $user_id = $this->user()->id;
        //根据个人id查询个人文章    返回全部
        $data = QqArticle::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($data as $key => $value) {
            $perName = $value->name;
            $perSchool = $value->school;
            foreach ($value->article as $k => $val) {
                $id = $val->id;
                $perMsgsCont[$id] = $val->content;
                $perMsgsType[$id] = $val->type;
                $perMsgsTag[$id] = $val->tag;
                $perMsgsVisi[$id] = $val->visible;
            }
        }

        return response()->json([
            "name" => $perName,
            "school" => $perSchool,
            "data" => [
                "content" => $perMsgsCont,
                "type" => $perMsgsType,
                "tag" => $perMsgsTag,
                "visible" => $perMsgsVisi
            ],
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
        $data = QqArticle::find($id);

        if (is_null($data)) {
            return response()->json(["messg" => "Record not found"], 404);
        }

        $data->update($request->all());

        return response()->json($data, 200);
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
        $data = QqArticle::find($id);

        if (is_null($data)) {
            return response()->json(["messg" => "Record not found"], 404);
        }

        $data->delete();

        return response()->json(null, 204);
    }
}
