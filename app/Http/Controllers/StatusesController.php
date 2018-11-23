<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusesController extends Controller
{
    /**
     * 用户登录之后才能执行的请求需要通过中间件来过滤
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 创建微博
     * @param Request $request
     */
    public function store(Request $request)
    {
        //验证规则
        $this->validate($request, [
            'content'=>'required|max:150'
        ]);

        /**
         * $user->statuses()->create();创建的微博会自动与用户进行关联
         * 借助 Laravel 提供的 Auth::user() 方法我们可以获取到当前用户实例
         */
        Auth::user()->statuses()->create([
           'content'=>$request['content'] ,
        ]);

//        return redirect()->route('users.show',Auth::user()->id);
        return redirect()->back();
    }


    /**
     * 删除操作
     * @param Status $status
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */

    public function destroy(Status $status)
    {

        $this->authorize('destroy',$status);

        $status->delete();
        session()->flash('success','成功删除该留言！');
        return redirect()->back();

    }
}
