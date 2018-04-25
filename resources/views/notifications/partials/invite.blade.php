@if($notification->user)
    <div class="singleNotification {{ $notification->seen ? '' : 'notification-new' }}" onclick="window.location.href='{{ URL::action('EventsController@show',  $notification->event_id) }}'">
        <div style="height: auto;padding:5px;">
            <label><strong>{{ $notification->user->username }}</strong> {{ trans("front.invitingYouToEvent") }}</label>
            <small> - {{ localDate($notification->created_at) }} {{ trans("front.at") }} {{ substr($notification->created_at, 11, 5) }}</small>
        </div>
    </div>
    <hr>
@endif