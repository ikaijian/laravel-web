<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
//    只让未登录用户访问登录页面
    public function __construct()
    {
        $this->middleware('guest',[
            'only'=>['create']
        ]);
    }

    //登陆
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

//        Auth::attempt() 方法可接收两个参数，第一个参数为需要进行用户身份认证的数组，第二个参数为是否为用户开启『记住我』功能的布尔值
        if (Auth::attempt($credentials,$request->has('remember'))) {

//            登录时检查是否已激活
            if (Auth::user()->activated){
                session()->flash('success','登陆成功，欢迎回来！！');
                //Auth::user() 方法来获取 当前登录用户 的信息，并将数据传送给路由
//            intended 方法，该方法可将页面重定向到上一次请求尝试访问的页面上，并接收一个默认跳转地址参数，当上一次请求记录为空时，跳转到默认地址上
                return redirect()->intended(route('users.show',[Auth::user()]));
            }else{
                Auth::logout();
                session()->flash('warning','你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }

        } else {
            session()->flash('danger','很抱歉你的邮箱或者密码错误!!!');
            return redirect()->back();
        }

    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success','你成功退出系统');
        return redirect('login');
    }
}
