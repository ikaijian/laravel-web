<li id="status-{{ $status->id }}">
    <a href="{{ route('users.show', $user->id )}}">
        <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="gravatar"/>
    </a>
    <span class="user">
    <a href="{{ route('users.show', $user->id )}}">{{ $user->name }}</a>
  </span>
    <span class="timestamp">
        {{--diffForHumans()方法的作用是将日期进行友好化处理:成形式"17 years ago"--}}
    {{ $status->created_at->diffForHumans() }}
  </span>
    <span class="content">{{ $status->content }}</span>

    @can('destroy', $status)
        <form action="{{ route('statuses.destroy', $status->id) }}" method="POST" onsubmit="return sumbit_sure()">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-sm btn-danger status-delete-btn">删除</button>
        </form>
    @endcan

</li>

<script src="/js/confirm.js"></script>


