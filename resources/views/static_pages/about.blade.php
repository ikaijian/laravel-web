{{--@extends 并通过传参来继承父视图 layouts/default.blade.php 的视图模板--}}
@extends('layouts.default')
{{--@section 和 @stop 代码来填充父视图的 content 区块，所有包含在 @section 和 @stop 中的代码都将被插入到父视图的 content 区块。--}}

{{--注意的是，当 @section 传递了第二个参数时，便不需要再通过 @stop 标识来告诉 Laravel 填充区块会在具体哪个位置结束--}}
@section('title','关于')
@section('content')
    <h>关于页</h>
@stop