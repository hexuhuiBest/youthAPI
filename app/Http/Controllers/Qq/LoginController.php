<?php

namespace App\Http\Controllers\Qq;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        //基础信息获取
        $appid = env('QQ_APP_ID','');
        $screat = env('QQ_APP_SECRET','');
        $js_code = $request->code;
        $grant_type = 'authorization_code';
        //获取session
        $session = $this->getSession($appid,$screat,$js_code,$grant_type);

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
        $body = $res->getContents();
        dd($body);


    }
}
