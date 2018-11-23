<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

//调用消息定制消息通知
use App\Notifications\ResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
//creating 用于监听模型被创建之前的事件，created 用于监听模型被创建之后的事件
//boot 方法会在用户模型类完成初始化之后进行加载，对事件的监听需要放在该方法中
    public static function boot()
    {
        parent::boot();
        static::creating(function($user){
            $user->activation_token=str_random(30);
        });
    }

//    User 模型里调用定制消息通知文件：
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
  }

  /**
   * 指明一个用户拥有多条微博
   * 获得拥有此用户所有微博
   *注意的一点是，由于一个用户拥有多条微博
   */

    public function statuses()
    {
//        return $this->hasMany('App\Models\Status');
        return $this->hasMany(Status::class);
    }

    /**
     * 动态流
     * 取出当前用户发布过的所有微博并根据创建时间来倒序排序
     * 为用户增加关注人的功能之后，将使用该方法来获取当前用户关注的人发布过的所有微博动态
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function feed()
    {
//        return $this->statuses()
//            ->orderBy('created_at','desc');

        //显示所有关注用户的微博动态
        $user_ids=\Auth::user()->followings->pluck('id')->toArray();
        array_push($user_ids,Auth::user()->id);
        return Status::whereIn('user_id',$user_ids)
            ->with('user')
            ->orderBy('created_at','desc');

    }

    /**
     * 关注的人和粉丝
     *
     * 通过followers获取粉丝关系列表
     *
     * 一个用户（粉丝）能够关注多个人，而被关注者能够拥有多个粉丝
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        /**
         * 两个关联模型的名称进行合并，并按照字母排序，生成的关联关系表名称会是 user_user。可以以自定义生成的名称，把关联表名改为 followers
         * belongsToMany 方法的第三个参数 user_id 是定义在关联中的模型外键名，而第四个参数 follower_id 则是要合并的模型外键名
         */
        return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }

    /**
     * 通过followings 来获取用户关注人列表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followings()
    {
        return $this->belongsToMany(User::class,'followers','follower_id','user_id');
    }


    /**
     * sync 和 detach 指定传递参数为用户的 id，这两个方法会自动获取数组中的 id
     */

    /**
     * 关注（follow）
     * @param $user_id
     */
    public function follow($user_ids)
    {
        if (!is_array($user_ids)){
            $user_ids=compact('user_ids');
        }
        //sync 方法会接收两个参数，第一个参数为要进行添加的 id，
        //第二个参数则指明是否要移除其它不包含在关联的 id 数组中的 id，true 表示移除，false 表示不移除，默认值为 true
        $this->followings()->sync($user_ids,false);

    }

    /**
     * 取消关注（unfollow)
     * @param $user_ids
     */

    public function unfollow($user_ids)
    {
        if(!is_array($user_ids)){
            $user_ids=compact('user_ids');
        }
        //借助 detach 来对用户进行取消关注的操作
        $this->followings()->detach($user_ids);
    }

    public function isFollowering($user_id)
    {
        return $this->followings->contains($user_id);
        //等价于下面
//        return $this->followings->contains($user_id);
    }
}
