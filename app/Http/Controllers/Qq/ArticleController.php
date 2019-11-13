<?php

namespace App\Http\Controllers\Qq;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\QqArticle;

class ArticleController extends Controller
{
    public function getArticle() {
        $data = QqArticle::get();
        // // dd($data);
        // foreach ($data as $key => $value) {
        //     echo $value -> id . '&emsp;' . $value -> content . '&emsp;' . $value -> QqUserInfo -> name ;
        // }
        return response()->json($data, 200);
    }
}
