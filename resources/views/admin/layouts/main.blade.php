<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ trans("admin.adminDashboard") }}</title>

    {!! Minify::stylesheet([
        "/css/bootstrap.min.css",
        "/css/admin-main.css"
    ]) !!}

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    {!! Minify::javascript([
        "/js/jquery.js",
        "/js/bootstrap.min.js",
        "/js/admin-script.js",
        "/js/jquery-ui.js"
    ]) !!}


    {!! HTML::style("css/sb-admin.css") !!}

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">


    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="{{ URL::action('Admin\AdminController@index') }}">{{ trans("admin.adminDashboard") }}</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">

            <li class="dropdown">
                @if(Auth::user())
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->username }} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ URL::action('UsersController@logout') }}"><i class="fa fa-fw fa-power-off"></i>{{ trans("admin.logout") }}</a>
                        </li>
                    </ul>
                @endif
            </li>
        </ul>

        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">

                <li>
                    <a href="{{ URL::action('HomeController@home') }}"><i class="fa fa-home"></i> {{ trans("admin.backToSite") }}</a>
                </li>

                <li class="@if(Request::is('admin')) active @endif">
                    <a href="{{ URL::action('Admin\AdminController@index') }}"><i class="fa fa-fw fa-dashboard"></i> {{ trans("admin.dashboard") }}</a>
                </li>

                <li class="@if(Request::is('*users')) active @endif">
                    <a href="{{ URL::action('Admin\UsersController@index') }}"><i class="fa fa-fw fa-users"></i> {{ trans("admin.users") }}</a>
                </li>

                <li class="@if(Request::is('*events')) active @endif">
                    <a href="{{ URL::action('Admin\EventsController@index') }}"><i class="fa fa-fw fa-calendar"></i> {{ trans("admin.events") }}</a>
                </li>

                <li class="@if(Request::is('*posts')) active @endif">
                    <a href="{{ URL::action('Admin\PostsController@index') }}"><i class="fa fa-file-text"></i> {{ trans("admin.posts") }}</a>
                </li>

                <li class="@if(Request::is('*comments')) active @endif">
                    <a href="{{ URL::action('Admin\CommentsController@index') }}"><i class="fa fa-comment"></i> {{ trans("admin.comments") }}</a>
                </li>

                <li class="@if(Request::is('*categories')) active @endif">
                    <a href="{{ URL::action('Admin\CategoriesController@index') }}"><i class="fa fa-sitemap"></i> {{ trans("admin.categories") }}</a>
                </li>

                <li class="@if(Request::is('*pages')) active @endif">
                    <a href="{{ URL::action('Admin\PagesController@index') }}"><i class="fa fa-file-o"></i> {{ trans("admin.pages") }}</a>
                </li>

                <li class="@if(Request::is('*settings')) active @endif">
                    <a href="{{ URL::action('Admin\SettingsController@index') }}"><i class="fa fa-cog"></i> {{ trans("admin.settings") }}</a>
                </li>

                <li class="@if(Request::is('*translation*')) active @endif">
                    <a href="{{ URL::action('Admin\TranslationController@front') }}"><i class="fa fa-book"></i> {{ trans("admin.translation") }}</a>
                </li>

            </ul>
        </div>
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            @yield("content")

            <br/>

        </div>

    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

</div>
</body>

</html>
