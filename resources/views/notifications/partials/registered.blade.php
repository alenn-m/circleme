@if($notification->user)
    <div class="singleNotification {{ $notification->seen ? '' : 'notification-new' }}" onclick="window.location.href='{{ URL::action('UsersController@show', $notification->user->username) }}'">
        <div style="height: auto;padding:5px;">
            <label><strong>{{ $notification->user->username }}</strong> {{ trans("front.hasJoined") }}</label>
            <small> - {{ localDate($notification->created_at) }} {{ trans("front.at") }} {{ substr($notification->created_at, 11, 5) }}</small>
        </div>
    </div>
    <hr>
@endif