<?php

namespace App\Http\Controllers\Qq;

use Illuminate\Http\Request;
use App\Models\QqFans;
use App\Http\Requests\Qq\FansRequest;

class FansController extends Controller
{
    
    public function fan($user_id){
        /**
         * user_id 为当前被关注者id   fan_id为当前操作者的id
         */
        //传过来的参数为当前文章作者id
        //找到操作对应的用户
        $operating_user = $this->user()->id;
        //检查fans表中有无信息
        // $user_id = $request->user_id;
        $data = QqFans::where('user_id', $user_id)
            ->where('fans_id', $operating_user)
            ->first();
        if ($data) {
            $data = $data->delete();
            if ($data) {
                return $this->respond(1, '取消关注成功');
            }
        } else {
            $data['user_id'] = $user_id;
            $data['fans_id'] = $this->user()->id;
            $data = QqFans::create($data);
            return $this->response(1, '关注成功', $data);
        }
    }

    // public function unattention($id)
    // {
    //     //传过来的参数为当前文章作者id
    //     //找到操作对应的用户
    //     $operating_user = $this->user()->id;
    //     //检查fans表中有无信息
    //     $data = QqFans::where('user_id', $id)
    //         ->where('fans_id', $operating_user)
    //         ->first();
    //     $record_id = $data->id;
    //     if (!$data) {
    //         QqFans::find($record_id)->delete();
    //         return $this->respond(1, '取消关注成功')->setStatusCode(200);
    //     } else {
    //         return $this->respond(0, '未查询到关注信息')->setStatusCode(200);
    //     }
    // }

    protected function respond($code, $message, $data = null)
    {
        return $this->response->array([
            'code' => $code,
            'data' => $data,
            'message' => $message
        ]);
    }
}
