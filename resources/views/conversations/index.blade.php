@extends("layouts.wide")

@section("content")

    <?php
    $url = Request::url();
    $temp = substr($url, strpos($url, "conversations/") + 14);
    ?>


    <div class="row">
        @if(count($conversations) > 0)
            <div class=" @if(Request::is('*conversations')) {{'conversationsOnly'}} @endif col-xs-12 col-sm-12 col-md-4" style="z-index:1;">
                <div class="list-group">
                    @foreach($conversations as $conversation)
                        @if(count($conversation->users) > 1)

                            <a style="padding:5px 10px;" href="{{ URL::action('ConversationsController@show', $conversation->id) }}" class="list-group-item @if($temp == $conversation->id) active-success @endif">
                                <div class="media">
                                    <span class="pull-left">
                                        <img style="width:64px;height:64px" src="{{ $conversation->otherUser()->first()->getAvatar() }}">
                                    </span>
                                    <div class="media-body">
                                        <strong>{{ $conversation->otherUser()->first()->username }}</strong>
                                        <span class="text-muted">
                                            <small style="margin-left:5px;"><i class="fa fa-clock-o"></i> {{ localDate($conversation->updated_at) }}</small>
                                        </span>

                                        <p style="color:gray;">{{ truncstring($conversation->messages()->orderBy('id', 'desc')->first()->message, 40) }}</p>
                                    </div>
                                </div>
                            </a>

                        @elseif(count($conversation->users) == 1)

                            <a style="padding:5px 10px;" href="{{ URL::action('ConversationsController@show', $conversation->id) }}" class="list-group-item @if($temp == $conversation->id) active-success @endif">
                                <div class="media">
                                    <span class="pull-left">
                                        <img style="width:64px;height:64px;" src="/img/nouser.png">
                                    </span>
                                    <div class="media-body">
                                        <strong>{{ trans("front.unknownUser") }}</strong>
                                        <span class="text-muted"><small style="margin-left:5px;"><i class="fa fa-clock-o"></i> {{ localDate($conversation->updated_at) }}</small></span>
                                        <p>{{ truncstring($conversation->messages()->orderBy('id', 'desc')->first()->message, 40) }}</p>
                                    </div>
                                </div>
                            </a>
                        @endif

                    @endforeach
                </div>
            </div>
        @else
            <h4>{{ trans("front.noMessages") }}</h4>
        @endif


        @if(count($conversations) > 0)
            <div class="col-md-8 col-sm-12">
                <div class="row">
                    <div class="col-xs-12">
                        @if(isset($messages))
                            @yield("conversation")
                        @else
                            <h4><small>{{ trans("front.selectMessage") }}</small></h4>
                        @endif
                    </div>
                </div>
            </div>
        @endif


    </div>

@endsection