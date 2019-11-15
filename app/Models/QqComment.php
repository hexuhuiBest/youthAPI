<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QqComment extends Model
{
    protected $table = "qq_comment";

    protected $guarded = ['id'];
    
    public $timestamps = false;
}
