@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h3>{{ trans("admin.translation") }}</h3>
        </div>
    </div>

    <br/>

    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <li class="@if(Request::is('*front')) active @endif"><a href="{{ URL::action('Admin\TranslationController@front') }}">{{ trans("admin.frontPage") }}</a></li>
                <li class="@if(Request::is('*admin')) active @endif"><a href="{{ URL::action('Admin\TranslationController@admin') }}">{{ trans("admin.admin") }}</a></li>
                <li class="@if(Request::is('*validation')) active @endif"><a href="{{ URL::action('Admin\TranslationController@validation') }}">{{ trans("admin.validation") }}</a></li>
            </ul>
        </div>
    </div>

    <br/>

    @yield("subcontent")

@endsection