<?php

namespace App\Http\Controllers\Qq;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Models\QqArticle;
use App\Models\QqArticleGood;
use App\Models\QqUserBasic;
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
        $operating_user = $this->user()->id;
        /**
         * 根据个人id查询个人文章    返回全部
         * $articleInfo中包含 该用户的基本信息
         * +该用户的全部文章+每一个文章的全部评论+评论者信息
         * +该文章的点赞总数+（待完善 -> 点赞者信息）
         * 注：必须foreach调用一下关联函数，直接调用无效，否则只返回文章信息
         * 注意：已鸡肋 目前采取方法不是一次性返回  而是分多次 
         * 功能转 UserBasicShow与UserBasicShowController
         */
        $articleAboutInfo = QqArticle::where('user_id', $operating_user)->get();
        foreach ($articleAboutInfo as $keys => $value) {
            $currentArticleId = $value->id;
            $value->author;
            $value->QqArticleGood;
            $countGood[$currentArticleId] =  QqArticleGood::where('article_id', $currentArticleId)->count();
            foreach ($value->comment as $key => $val) {
                $val->author;
            }
        }

        return response()->json([
            "articleAboutInfo" => $articleAboutInfo,
            "countGood" => $countGood,
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
            'content' => 'required|min:3'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $data = $request->only(['content']);
        $data['user_id'] = $this->user()->id;
        if ($request->fileList) {
            $data['pictures'] = json_encode($request->pictures);
        }
        $data = QqArticle::create($data);

        return $this->respond(1,'创建成功',$data)->setStatusCode(200);
    }

    public function pictStore(ImageUploadHandler $handler,UserRequest $request)
    {
        if ($request->pictures) {
            $result = $handler->save($request->pictures, $request->type, $this->user()->id,$request->max_width);
            if ($result) {
                $data = $request->only(['type']);
                $data['path'] = $result['path'];
//                $data['mini_path'] = $result['mini_path'];
                $data['user_id'] = $this->user()->id;
                $data['filename'] = '0';
                $picture =  Picture::create($data);
            }
            if($picture){
                $pictures['mini_path'] = $picture->mini_path;
                $pictures['path'] = $picture->path;
                $pictures['id'] = $picture->id;
                return $this->respond('1','上传成功',$pictures);
            }else{
                return $this->respond('0','失败稍后重试');
            }
        }
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
    protected function respond($code,$message,$data=null)
    {
        return $this->response->array([
            'code'=>$code,
            'data'=>$data,
            'message'=>$message
        ]);
    }
}
