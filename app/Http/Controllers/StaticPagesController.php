<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class StaticPagesController extends Controller
{
    //
    public function home()
    {
        /**
         * 由于用户在访问首页时，可能存在登录或未登录两种状态
         * 获取用户的微博动态
         */

        $feed_items=[];
        if (Auth::check()){
            $feed_items=Auth::user()->feed()->paginate(10);
        }
        //view 方法接收两个参数，第一个参数是视图的路径名称，第二个参数是与视图绑定的数据，第二个参数为可选参数。
        return view('static_pages.home',compact('feed_items'));
    }

    public function help()
    {
        return view('static_pages.help');
    }

    public function about()
    {
        return view('static_pages/about');
    }
}
