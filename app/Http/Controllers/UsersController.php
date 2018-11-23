<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class UsersController extends Controller
{

    public function __construct()
    {
//        middleware方法，该方法接收两个参数，第一个为中间件的名称，第二个为要进行过滤的动作
        $this->middleware('auth',[
//        通过 except 方法来设定 指定动作 不使用 Auth 中间件进行过滤，
//        意为 —— 除了此处指定的动作以外，所有其他动作都必须登录用户才能访问，类似于黑名单的过滤机制。
//        相反的还有 only 白名单方法，将只过滤指定动作
            'except'=>['show','create','store','index','confirmEmail']
        ]);

//        只让未登录用户访问注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //列出所有用户
    public function index()
    {
//        $users=User::all();
        $users=User::paginate(10);
        return view('users.index',compact('users'));

    }

    //注册用户视图
    public function create()
    {
        return view('users.create');
    }

    /**
     * 个人页面显示
     * 微博条数展示获取渲染
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {

        $statuses=$user->statuses()
            ->orderBy('created_at','desc')
            ->paginate(10);
//        dd($statuses);
//        将用户对象 $user 通过 compact 方法转化为一个关联数组，并作为第二个参数传递给 view 方法，将数据与视图进行绑定
        return view('users.show', compact('user','statuses'));
    }


    public function store(Request $request)
    {
        //validate 方法接收两个参数，第一个参数为用户的输入数据，第二个参数为该输入数据的验证规则
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        //保存用户并重定向
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
//        //注册成功后自动登陆
//        Auth::login($user);

        //替换为了激活邮箱的发送操作
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收!!');

        return redirect('/');
//        //消息提示
//        session()->flash('success', '欢迎，您将在这里开启一段新的旅程----学习~');
//        return redirect(route('users.show', [$user]));
    }

    //发送邮件
    public function sendEmailConfirmationTo($user)
    {
        $view='emails.confirm';
        $data=compact('user');
        $from='1144285537@qq.com';
        $name='jeesonjian';
        $to=$user->email;
        $subject="感谢注册账号！请确认你的邮箱。";

        Mail::send($view,$data,function($message) use ($from,$name,$to,$subject){
            $message->from($from,$name)->to($to)->subject($subject);
        });
    }

    //激活功能
    public function confirmEmail($id,$token)
    {
//        $user=User::where('activation_token',$token)->firstOrFail();
        $user=User::find($id);//根据id找到用户
        // 匹配 token ，确认激活，更新数据
        if($user->activation_token==$token){
            $user->activated=true;
            $user->activation_token=null;
            $user->save();

            // 自动登陆，发送提示，重定向
            Auth::login($user);
            session()->flash('success','恭喜你，激活成功！');
            return redirect()->route('users.show', [$user]);
        }else{
            session()->flash('danger', '激活失败。请再次点击邮件中的链接重试');
            return redirect('/');
        }

    }


    public function edit(User $user)
    {
//        authorize 方法接收两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据
//        这里 update 是指授权类里的 update 授权方法，$user 对应传参 update 授权方法的第二个参数
        //友好提示try{}catch(){}
        try{
            $this->authorize('update',$user);
        }catch (AuthorizationException $e){
            return abort(403,'无权访问');
        }

        return view('users.edit', compact('user'));
    }

    //更新
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
//            'password'=>'required|confirmed|min:6',
            'password' => 'nullable|confirmed|min:6',
        ]);

        try{
            $this->authorize('update',$user);
        }catch (AuthorizationException $e){
            return abort(403,'无权访问');
        }


        $data=[];
        $data['name']=$request->name;
        if ($request->password){
            $data['password']=bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');
        return redirect()->route('users.show', $user->id);
    }


    //删除用户
    public function destroy(User $user)
    {
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','删除用户成功');
        return back();
    }

    /**
     * 用于显示用户关注人列表视图的 followings 方法
     * @param User $user
     */
    public function followings(User $user)
    {
        $users=$user->followings()->paginate(10);
        $title="关注的人";
        return view('users.show_follow',compact('users','title'));
    }

    /**
     * 用户显示粉丝列表的 followers 方法
     * @param User $user
     */
    public function followers(User $user)
    {
        $users=$user->followers()->paginate(10);
        $title="粉丝";
        return view('users.show_follow',compact('users','title'));
    }
}
