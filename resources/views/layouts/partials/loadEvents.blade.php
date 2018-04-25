<div id="grid" data-columns class="col-xs-12">
    @if(isset($events) and count($events) > 0)
        @foreach($events as $event)
            <div class="container-fluid singleEvent">
                <div class="row">
                    <div class="col-xs-12" style="padding: 0; margin: 20px 0 0 0;">
                        <a href="{{ URL::action('EventsController@show', ["id" => $event->id, "slug" => $event->slug]) }}">
                            @if($event->getImage())
                                {!! HTML::image($event->getImage(), "Cover", ["width" => "100%"]) !!}
                            @endif
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <a href="{{ URL::action('EventsController@show', ["id" => $event->id, "slug" => $event->slug]) }}">
                            <h4>{{ $event->title }}</h4>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <p>{{ $event->description }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6" style="text-align: left;">
                        <span>
                            <small>
                                @if($event->city)
                                    <i class="fa fa-map-marker"></i>
                                    {{ $event->city }}
                                @else
                                    @if($event->country)
                                        <i class="fa fa-map-marker"></i>
                                        {{ Config::get("countries." . $event->country) }}
                                    @endif
                                @endif
                            </small>
                        </span>
                    </div>

                    @if($event->time && $event->time != 0)
                        <div class="col-xs-12" style="text-align: right;">
                            <span><small><i class="fa fa-clock-o"></i> <strong>{{ smart_date($event->date) }}</strong> {{ trans("front.at") }} {{ substr($event->time, 0, 2) . ":" . substr($event->time, 2, 2) }}</small></span>
                        </div>
                    @endif
                </div>

                @if(Request::is("*calendar/discover"))
                    <div class="row">
                        <div class="col-xs-12">
                            <h4><small>{{ trans("front.areyouGoing") }}</small></h4>
                            <a style="margin:0 5px" class="btn btn-primary " href="{{ URL::action('EventsController@isGoing', ['event' => $event->id, 'answer' => 'yes']) }}">{{ trans("front.yes") }}</a>
                            <a style="margin:0 5px" class="btn btn-primary " href="{{ URL::action('EventsController@isGoing', ['event' => $event->id, 'answer' => 'no']) }}">{{ trans("front.no") }}</a>
                            <a style="margin:0 5px" class="btn btn-primary " href="{{ URL::action('EventsController@isGoing', ['event' => $event->id, 'answer' => 'maybe']) }}">{{ trans("front.maybe") }}</a>
                        </div>
                    </div>
                    <br/>
                @endif
            </div>
        @endforeach

    @else

        <h3><small>{{ trans("front.noevents") }}</small></h3>

    @endif
</div>

@if(isset($events))
    {!! $events->render() !!}
@endif

<script>
    $("#grid").infinitescroll({
        navSelector     : ".pagination",
        nextSelector    : ".pagination a:last",
        itemSelector    : ".singleEvent",
        debug           : false,
        dataType        : 'html',
        loadingText  	: "{{ trans('front.loading') }}...",
        donetext		: "",
        path: function(index) {
            if(window.location.href.indexOf("?search=") > -1){
                return window.location.href + "&page=" + index;
            }else{
                return "?page=" + index;
            }

        },
        loading : {
            msgText: "",
            finishedMsg: "",
        }
    }, function(newElements, data, url){
        console.log(newElements);
        var grid = document.querySelector('#grid');

        salvattore.appendElements(grid, newElements);
    });
</script>