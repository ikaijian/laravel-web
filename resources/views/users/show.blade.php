@extends('layouts.default')

@section('title',$user->name)
@section('content')
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="col-md-12">
                <div class="col-md-offset-2 col-md-8">
                    <section class="user_info">
                        {{--//通过给 @include 方法传参，将用户数据以关联数组的形式传送到 _user_info 局部视图上--}}
                        @include('shared._user_info', ['user' => $user])
                    </section>

                    <section class="stats">
                        @include('shared._stats',['user'=>$user])
                    </section>
                </div>
            </div>

            <div class="col-md-12">

                @if(Auth::check())
                    @include('users._follow_form');
                @endif

                @if (count($statuses) > 0)
                    <ol class="statuses">
                        @foreach ($statuses as $status)
                            @include('statuses._status')
                        @endforeach
                    </ol>
                    {!! $statuses->render() !!}
                @endif
            </div>
        </div>
    </div>
    {{--{{$user->name}}-{{$user->email}}--}}
@stop
