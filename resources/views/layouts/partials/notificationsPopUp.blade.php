<ul class="dropdown-menu centerMenu" role="menu" style="width:350px;">

    @if(isset($notifications) && count($notifications) > 0)
        @foreach($notifications as $notification)

            @if($notification->type == "invite")
                <li class="message-preview">
                    <a style="padding:5px 10px;" href="{{ URL::action("EventsController@show", $notification->event_id) }}">

                        <div class="media">
                            <span class="pull-left">
                                <img width="50" height="50" src="{{ $notification->user->getAvatar() }}">
                            </span>
                            <div class="media-body">
                                <label class="notificationText {{ $notification->seen ? '' : 'notification-new' }}">
                                    <span>
                                        <strong>
                                            {{ $notification->user->getFullname() }}
                                        </strong>
                                    </span>

                                    {{ trans("front.invitingYouToEvent") }}
                                </label><br>

                                <label class="text-muted">{{ localDate($notification->created_at) }}</label>
                            </div>
                        </div>
                    </a>
                </li>

                <li class="divider"></li>
            @endif

            @if($notification->type == "massmessage")
                <li class="message-preview">
                    <a style="padding:5px 10px;" href="{{ URL::action("EventsController@show", $notification->event_id) }}">

                        <div class="media">
                        <span class="pull-left">
                            <img width="50" height="50" src="{{ $notification->user->getAvatar() }}">
                        </span>
                            <div class="media-body">
                                <label class="notificationText {{ $notification->seen ? '' : 'notification-new' }}">
                                <span>
                                    <strong>
                                        {{ $notification->user->getFullname() }}
                                    </strong>
                                </span>

                                    {{ trans("front.youGotNewMessage") }}
                                </label><br>

                                <label class="text-muted">{{ localDate($notification->created_at) }}</label>
                            </div>
                        </div>
                    </a>
                </li>

                <li class="divider"></li>
            @endif

            @if($notification->type == "registered")
                <li class="message-preview">
                    <a style="padding:5px 10px;" href="{{ URL::action("UsersController@show", $notification->user->username) }}">

                        <div class="media">
                        <span class="pull-left">
                            <img width="50" height="50" src="{{ $notification->user->getAvatar() }}">
                        </span>
                            <div class="media-body">
                                <label class="notificationText {{ $notification->seen ? '' : 'notification-new' }}">
                                <span>
                                    <strong>
                                        {{ $notification->user->getFullname() }}
                                    </strong>
                                </span>

                                    {{ trans("front.hasJoined") }}
                                </label><br>

                                <label class="text-muted">{{ localDate($notification->created_at) }}</label>
                            </div>
                        </div>
                    </a>
                </li>

                <li class="divider"></li>
            @endif
        @endforeach

        <li><a id="seeAll" href="{{ URL::action('NotificationsController@index') }}">{{ trans("front.seeAll") }}</a></li>

    @else

        <li><a href="#">{{ trans("front.nonewNotifications") }}</a></li>
        <li class="divider"></li>
        <li><a id="seeAll" href="{{ URL::action('NotificationsController@index') }}">{{ trans("front.seeAll") }}</a></li>

    @endif
</ul>