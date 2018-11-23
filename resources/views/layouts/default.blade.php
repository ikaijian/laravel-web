<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Sample App') - Laravel 入门教程</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
{{--header--}}
@include('layouts._header')
{{--end header--}}

{{--@yield 传了两个参数，第一个参数是该区块的变量名称，第二个参数是默认值，表示当指定变量的值为空值时，使用 Sample 来作为默认值。--}}
<div class="container">
    {{--<div class="col-md-offset-1 col-md-10">--}}
    @include('shared._messages')
    @yield('content')
    @include('layouts._footer')
    {{--</div>--}}
</div>

<script src="/js/app.js"></script>
</body>
</html>