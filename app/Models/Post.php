<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];
    function user(){
        return $this->hasOne('App\Models\User','id','post_by');
    }
    function category(){
        return $this->hasOne('App\Models\Category','id','category_id');
    }
}
