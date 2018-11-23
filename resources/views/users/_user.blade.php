<li>
    <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="gravatar"/>
    <a href="{{ route('users.show', $user->id) }}" class="username">{{ $user->name }}</a>

    {{--//@can Blade 命令做授权判断--}}
    @can('destroy',$user)
        <form action="{{route('users.destroy',$user->id)}}" method="POST" onsubmit="return sumbit_sure()">
            {{csrf_field()}}
            {{method_field('DELETE')}}
            <button type="submit" class="btn btn-lg btn-danger delete-btn">删除</button>
        </form>
    @endcan
</li>

<script src="/js/confirm.js"></script>


