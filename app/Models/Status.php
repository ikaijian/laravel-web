<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    public $fillable=['content'];
    /**
     *  指明一条微博属于一个用户
     * 获得拥有此微博的用户id
     */
    public function user()
    {
//        return $this->belongsTo('App\Models\User');
        return $this->belongsTo(User::class);
    }
    

}
