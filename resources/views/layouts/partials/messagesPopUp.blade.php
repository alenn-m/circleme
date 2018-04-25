<ul class="dropdown-menu centerMenu" role="menu" style="width:350px;">
@if(isset($conversations) && count($conversations) > 0)
    @foreach($conversations as $conversation)
        @if(count($conversation->users) > 1)
        <li class="message-preview">
            <a style="padding:5px 10px;" href="{{ URL::action('ConversationsController@show', $conversation->id) }}">
                <div class="media">
                    <span class="pull-left">
                        <img style="width:50px;height:50px;" src="{{ $conversation->otherUser()->first()->getAvatar() }}">
                    </span>
                    <div class="media-body">
                        <strong>{{ $conversation->otherUser()->first()->username }}</strong>
                        <span class="text-muted">
                            <small style="margin-left:5px;"><i class="fa fa-clock-o"></i> {{ localDate($conversation->updated_at) }}</small>
                        </span>

                        <p>{{ truncstring($conversation->messages()->orderBy('id', 'desc')->first()->message, 40) }}</p>
                    </div>
                </div>
            </a>
        </li>
        @elseif(count($conversation->users) == 1)
        <li class="message-preview">
            <a style="padding:5px 10px;" href="{{ URL::action('ConversationsController@show', $conversation->id) }}">
                <div class="media">
                        <span class="pull-left">
                            <img style="width:50px;height:50px" src="/img/nouser.png">
                        </span>
                    <div class="media-body">
                        <strong>{{{ trans("front.unknownUser") }}}</strong>
                        <span class="text-muted">
                            <small style="margin-left:5px;"><i class="fa fa-clock-o"></i> {{ localDate($conversation->updated_at) }}</small>
                        </span>

                        <p>{{ truncstring($conversation->messages()->orderBy('id', 'desc')->first()->message, 40) }}</p>
                    </div>
                </div>
            </a>
        </li>
        @endif

        <li class="divider"></li>

    @endforeach

    <li><a id="seeAll" href="{{ URL::action('ConversationsController@index') }}">{{ trans("front.seeAll") }}</a></li>

@else

    <li><a href="#">{{ trans("front.noMessages") }}</a></li>

@endif
</ul>