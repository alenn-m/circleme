<div class="row">
    <div class="col-xs-12">
        <div class="btn-group">
            <a href="{{ URL::action('CirclesController@index') }}" class="btn btn-primary btn-sm @if(Request::is('circles')) active @endif">{{ trans("front.myfriends") }}</a>
            <a href="{{ URL::action('CirclesController@findpeople') }}" class="btn btn-primary btn-sm @if(Request::is('circles/find')) active @endif">{{ trans("front.findpeople") }}</a>
        </div>

        <a href="{{ URL::action('InvitesController@index') }}" class="btn btn-default btn-sm pull-right @if(Request::is('invites')) active @endif">{{ trans("front.invite") }}</a>
    </div>
</div>

<br/>