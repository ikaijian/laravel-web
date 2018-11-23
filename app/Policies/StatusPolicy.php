<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * 当被删除的微博作者为当前用户授权才能通过删除操作
     */
    public function destroy(User $user, Status $status)
    {
        return $user->id === $status->user_id;
    }

}
