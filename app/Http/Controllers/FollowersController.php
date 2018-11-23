<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class FollowersController extends Controller
{
    //关注功能的逻辑处理

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 关注
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(User $user)
    {
        if (Auth::user()->id===$user->id){
            return redirect('/');
        };
        if (!Auth::user()->isFollowering($user->id)){
            Auth::user()->follow($user->id);
        }
        return redirect()->route('users.show',$user->id);
    }

    /**
     * 取消关注
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(User $user)
    {
        if (Auth::user()->id===$user->id){
            return redirect('/');
        }
        if (Auth::user()->isFollowering($user->id)){
            Auth::user()->unfollow($user->id);
        }
        return redirect()->route('users.show',$user->id);
    }
}
