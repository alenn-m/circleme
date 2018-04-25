<nav class="navbar navbar-default" style="margin-bottom:0;">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::action('HomeController@home') }}">
                @if(Config::get("settings.logo"))
                    {!! HTML::image("/uploads/" . Config::get("settings.logo"), "Logo", ["width" => "110", "height" => "30"]) !!}
                @else
                    {{ Config::get("settings.title", "Events") }}
                @endif
            </a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <form class="navbar-form navbar-left" role="search" action="{{ URL::action('SearchController@search') }}" method="get">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="{{ trans('front.search') }}..." name="search">
                    </div>
                </div>
            </form>

            @if(Auth::user())
                <ul class="nav navbar-nav nav-large">

                    <li class="dropdown pull-left small-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-envelope-o"></i>
                        </a>
                        @include("layouts.partials.messagesPopUp")
                    </li>

                    <li class="dropdown pull-left notif-dropdown" data-url="{{ URL::action('NotificationsController@seenNotification') }}">
                        <a href="#" id="notificationIcon" class="dropdown-toggle small-padding notificationIcon" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-bell-o"></i>
                            @if($unreadNotif > 0)
                                <span class="label label-danger badge-label"><span class="notif-number">{{ $unreadNotif }}</span></span>
                            @endif
                        </a>

                        @include("layouts.partials.notificationsPopUp")
                    </li>
                </ul>
            @endif

            <ul class="nav navbar-nav navbar-right">
                @if(Auth::user())
                    <li><a href="{{ URL::action('EventsController@create') }}">{{ trans("front.addEvent") }}</a></li>
                    <li><a href="{{ URL::action('EventsController@upcoming') }}"><i class="fa fa-calendar-check-o"></i> <span class="hidden-sm">{{ trans("front.planner") }}</span></a></li>
                    <li class="dropdown">
                        <a style="padding-top: 15px;padding-bottom: 15px;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

                            {!! HTML::image(Auth::user()->getAvatar(), Auth::user()->username, ["class" => "avatar"]) !!}
                            <span class="caret"></span></a>

                        <ul class="dropdown-menu">
                            @if(Auth::user()->role == "admin")
                            <li><a href="{{ URL::action('Admin\AdminController@index') }}">{{ trans("front.admin") }}</a></li>
                            @endif
                            <li><a href="{{ URL::action('CirclesController@index') }}">{{ trans("front.circles") }}</a></li>
                            <li><a href="{{ URL::action("EventsController@myevents") }}">{{ trans("front.myEvents") }}</a></li>
                            <li><a href="{{ URL::action("UsersController@show", Auth::user()->username) }}">{{ trans("front.profile") }}</a></li>
                            <li><a href="{{ URL::action("SettingsController@index") }}">{{ trans("front.settings") }}</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ URL::action('UsersController@logout') }}">{{ trans("front.logout") }}</a></li>
                        </ul>
                    </li>

                @else
                    <li><a href="{{ URL::action("UsersController@login") }}">{{ trans("front.login") }}</a></li>
                    <li><a href="{{ URL::action('UsersController@signup') }}">{{ trans("front.signup") }}</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

