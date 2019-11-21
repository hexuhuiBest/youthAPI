<?php

namespace App\Transformers;

use App\Models\QqUser;
use App\Models\QqUserBasic;
use League\Fractal\TransformerAbstract;

class QqUserTransformer extends TransformerAbstract
{
    public function transform(QqUser $user)
    {
        $data = QqUserBasic::where('user_id',$user->id)->first();
        return [
            'id' => $user->id,
            'school' => $user->school,
            'offical' => $user->offical,
            'sex' => $user->sex,
            'des' => $user->des,
            'tags' => $user->tags,
            'level'=>$user->level,
            'gender'=>$data->gender,
            'language'=>$data->language,
            'city'=>$data->city,
            'province'=>$data->province,
            'country'=>$data->country,
            'name'=>$data->name,
            'nickName'=>$user->nickName,
            'avatarUrl'=>$user->avatarUrl,
            'last_actived_at' => $user->last_actived_at,
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString(),
        ];
    }
}