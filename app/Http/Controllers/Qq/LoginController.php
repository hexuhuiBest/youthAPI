<?php

namespace App\Http\Controllers\Qq;

use App\Http\Requests\Qq\QqappAuthorizationRequest;
use App\Http\Requests\QqBasicInfoTransformer;
use App\Models\QqUser;
use App\Transformers\QqUserTransformer;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function qqappStore(QqappAuthorizationRequest $request)
    {
        //基础信息获取
        $appid = env('QQ_APP_ID','1109907963');
        $screat = env('QQ_APP_SECRET','HMvNCSI92kAlxjGq');
        $js_code = $request->code;
        $grant_type = 'authorization_code';
        //获取code
        $data = $this->getSession($appid,$screat,$js_code,$grant_type);//获取失败时返回code为空
        if ($data['errcode']!=0) {
            return $this->response->array([
                'code' =>$data['errcode'],
                'message'=>$data['errmsg'],
            ]);
        }
        //找到 openid 对应的用户
        $user = QqUser::where('qqapp_openid', $data['openid'])->first();

        if(!$user) {
            $user = QqUser::create([
                'qqapp_openid' => $data['openid'],
                'qqapp_session_key' => $data['session_key'],
            ]);
        }
        $token = Auth::guard('qq')->fromUser($user);

        return $this->respondWithToken($token)->setStatusCode(200);
    }
    public function update()
    {
        $token = Auth::guard('qq')->refresh();
        return $this->respondWithToken($token);
    }

    public function destroy()
    {
        Auth::guard('qq')->logout();
        return $this->response->noContent();
    }

    public function me()
    {
        $data = new QqUserTransformer();
        $data = $data->transform($this->user());
        return $this->respond(-1,'请求成功',$data);
    }
    public function meUpdate(QqappAuthorizationRequest $request)
    {
        $user = $this->user();
        $info = $request->only(['school','offical','sex','des','tags','level']);
        $user ->update($info);
        if($user){
            $data = $this->response->item($this->user(), new QqUserTransformer());
            return $this->respond(1,'更新成功',$data);
        }else{
            return $this->respond(-1,'更新失败请稍后重试');
        }
    }



    protected function respondWithToken($token)
    {
        $data = array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('qq')->factory()->getTTL() * 60,
        ]);
        return $this->response->array([
            'code'=>'1',
            'data'=>$data,
            'message'=>'请求成功'
        ]);
    }
    protected function respond($code,$message,$data=null)
    {
        return $this->response->array([
            'code'=>$code,
            'data'=>$data,
            'message'=>$message
        ]);
    }
    protected function getSession($appid,$screat,$js_code,$grant_type)
    {
        $session_url = 'https://api.q.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$screat.'&js_code='.$js_code.'&grant_type='.$grant_type;
        //获取session
        $client = new Client();
        $res = $client->request('GET', $session_url);
        if ($res->getStatusCode() != 200) {
            return $this->response->error('源服务器错误', 500);
        }
        $body = $res->getbody();
        $contents = $body->getContents();
        $arr = json_decode($contents,true);
        return $arr;
    }
}
