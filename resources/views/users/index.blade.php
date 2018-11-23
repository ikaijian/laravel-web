@extends('layouts.default')
@section('title','所有用户')
@section('content')
    <div class="col-md-offset-2 col-md-8">
        <h1>所有用户</h1>
        <ul class="users">
            @foreach ($users as $user)
                {{--将单个用户视图抽离成一个完整的局部视图--}}
               @include('users._user')
            @endforeach
        </ul>
        {!! $users->render() !!}
    </div>
@stop