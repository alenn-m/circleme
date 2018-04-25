@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h2 class="top-heading">{{ trans("admin.settings") }}</h2>
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <li class="@if(Request::is('*settings')) active @endif"><a href="{{ URL::action('Admin\SettingsController@index') }}">{{ trans("admin.basic") }}</a></li>
                <li class="@if(Request::is('*ads')) active @endif"><a href="{{ URL::action('Admin\SettingsController@getAds') }}">{{ trans("admin.ads") }}</a></li>
                <li class="@if(Request::is('*email')) active @endif"><a href="{{ URL::action('Admin\SettingsController@getEmailSettings') }}">{{ trans("admin.emailSettings") }}</a></li>
                <li class="@if(Request::is('*predefined')) active @endif"><a href="{{ URL::action('Admin\SettingsController@getPredefinedEmail') }}">{{ trans("admin.predefinedEmail") }}</a></li>
                <li class="@if(Request::is('*services')) active @endif"><a href="{{ URL::action('Admin\SettingsController@getServices') }}">{{ trans("admin.services") }}</a></li>
            </ul>
        </div>
    </div>

    <br/>

    @yield("settings")

@endsection