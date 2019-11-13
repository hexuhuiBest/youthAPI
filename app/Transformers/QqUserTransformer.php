<?php

namespace App\Transformers;

use App\Models\QqUser;
use League\Fractal\TransformerAbstract;

class QqUserTransformer extends TransformerAbstract
{
    public function transform(QqUser $user)
    {
        return [
            'id' => $user->id,
            'school' => $user->school,
            'offical' => $user->offical,
            'sex' => $user->sex,
            'des' => $user->des,
            'tags' => $user->tags,
            'level'=>$user->level,
            'last_actived_at' => $user->last_actived_at,
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString(),
        ];
    }
}