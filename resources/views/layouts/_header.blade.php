<header class="navbar navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="col-md-offset-1 col-md-10">
            <a href="{{route('home')}}" id="logo">Jeesonjian-App</a>
            <nav>
                <ul class="nav navbar-nav navbar-right">
                    {{--<li><a href="/help">帮助</a></li>--}}
                    {{--Auth::check() 方法用于判断当前用户是否已登录，已登录返回 true，未登录返回 false--}}
                    @if(Auth::check())
                        <li><a href="{{route('users.index')}}">用户列表</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                {{Auth::user()->name}}<b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{route('users.show',Auth::user()->id)}}">个人中心</a></li>
                                <li><a href="{{route('users.edit',Auth::user()->id)}}">编辑资料</a></li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#" id="logout">
                                        <form action="{{route('logout')}}" method="POST">
                                            {{csrf_field()}}
                                            {{--退出操作需要使用 DELETE 请求来发送给服务器。由于浏览器不支持发送 DELETE 请求，需要使用一个隐藏域来伪造 DELETE 请求--}}
                                            {{method_field('DELETE')}}
                                            {{--相当于下面表单--}}
                                            {{--<input type="hidden" name="_method" value="DELETE">--}}
                                            <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                                        </form>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    @else
                        {{--语法--}}
                        {{--{{　}} 是在 HTML 中内嵌 PHP 的 Blade 语法标识符--}}
                        {{--route() 方法由 Laravel 提供，通过传递一个具体的路由名称来生成完整的 URL：http://www.laravel-web1.com/help--}}
                        <li><a href="{{route('help')}}">帮助</a></li>
                        <li><a href="{{route('login')}}">登录</a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</header>
