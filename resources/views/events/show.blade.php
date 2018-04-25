@extends("layouts.main")

@section("meta")

    {!! $og->renderTags() !!}

@endsection

@section("content")

    {!! Config::get("settings.addthis_code") !!}

    {!! Minify::stylesheet(["/css/jquery.fileupload.css", "/css/bootstrap-suggest.css"]) !!}
    {!! Minify::javascript(["/js/jquery.fileupload.js", "/js/bootstrap-suggest.js"]) !!}

    <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>

    @if(Auth::user() && (Auth::user()->id == $event->user_id || $event->guestCanInvite))
        @if(!(strtotime($event->date) < strtotime(date('Y-m-d'))))
            <div class="modal fade" id="inviteUsers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ trans("front.inviteMorePeople") }}</h4>
                        </div>
                        <div class="modal-body">
                            <h3>{{ trans("front.loading") }}...</h3>
                        </div>
                        <div class="modal-footer">
                            {!! Form::open(["url" => URL::action("EventsController@invite", $event->id)]) !!}
                                {!! Form::hidden("users", null, ["class" => "selected-users"]) !!}
                            <button type="submit" class="btn btn-primary">{{ trans("front.invite") }}</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans("front.close") }}</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

    @if(Auth::user() and Auth::user()->id == $event->user_id)
        <div class="modal fade" id="massMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{ trans("front.sendMessageToGuests") }}</h4>
                    </div>
                    {!! Form::open(["url" => URL::action("EventsController@massMessage", $event->id)]) !!}
                    <div class="modal-body">
                        <h5><small>{{ trans("front.userReceiveMessagePostNotificationEmail") }}</small></h5>

                        {!! Form::textarea("body", null, ["placeholder" => trans("front.message"), "class" => "form-control massMessage"]) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ trans("front.send") }}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans("front.close") }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-xs-12">

            <div style="overflow:hidden;height:375px;position:relative;">
                {!! HTML::image($event->getImage(), "Cover", ["width" => "100%", "class" => "coverImageShow", "style" => "position:absolute;top:".$event->cover_position . "px"]) !!}
            </div>

            <div class="event-basic-info">
                <h4 style="display:inline-block">
                    {{ $event->title }}
                </h4>

                @if(Auth::user() && Auth::user()->id == $event->user_id)
                    <div class="pull-right">
                        <a class="btn btn-default" href="{{ URL::action('EventsController@edit', $event->id) }}">{{ trans("front.editEvent") }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if(Config::get("settings.ad3"))
        <div class="row">
            <div class="col-xs-12">
                {!! Config::get("settings.ad3") !!}
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 col-xs-12">
        @if(Auth::user() && (Auth::user()->id == $event->user_id || $event->guestCanPublish == 1))
            <div class="row">
                <div class="col-xs-12">
                    <div class="white-box" style="padding:20px 0;">
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::open(["url" => URL::action("PostsController@store"), "class" => "event-post-form"]) !!}
                                <div class="col-xs-2" style="text-align: center">
                                    {!! HTML::image(Auth::user()->getAvatar(), "User", ["class" => "event-avatar"]) !!}
                                </div>

                                <div class="col-xs-7">
                                    {!! Form::text("body", null, ["placeholder" => trans("front.saySomething"), "class" => "form-control post-input", "data-url" => URL::action("UsersController@allUsers")]) !!}
                                    {!! Form::hidden("event_id", $event->id) !!}

                                    <div class="comment-buttons">
                                        {!! Form::submit(trans("front.publish"), ["class" => "btn btn-success btn-sm post-submit", "disabled"]) !!}
                                        <a class="btn btn-default btn-sm post-cancel">{{ trans("front.cancel") }}</a>
                                    </div>
                                </div>

                                    {!! Form::hidden("image", null, ["class" => "image-path"]) !!}
                                {!! Form::close() !!}

                                <div class="col-xs-3">
                                    <span class="fileinput-button btn btn-default upload-image">
                                        <i class="fa fa-picture-o"></i>
                                        <input id="fileupload" type="file" name="file">
                                    </span>
                                </div>

                                <div class="image-loader">
                                    <p>{{ trans("front.uploading") }} <span id="percent">0%</span></p>
                                </div>
                            </div>
                        </div>



                        <div class="row event-image-holder"> <br/><div class="col-xs-12"></div></div>

                    </div>
                </div>
            </div>


        @endif

            <div class="loadPosts">
                @include("events.partials.posts")
            </div>
        </div>

        <div class="col-md-6 col-xs-12">

        @if(!(strtotime($event->date) < strtotime(date('Y-m-d'))))
            @if(Auth::user())
                <div class="row">
                    <div class="col-xs-12">
                        <div class="white-box">
                            <h4>{{ trans("front.areyouGoing") }}</h4>
                            @if($isGoing)
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    {{ trans("front." . $isGoing->type) }}
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="{{ URL::action('EventsController@isGoing', ['event' => $event->id, 'answer' => 'yes']) }}">{{ trans("front.yes") }}</a></li>
                                    <li><a href="{{ URL::action('EventsController@isGoing', ['event' => $event->id, 'answer' => 'no']) }}">{{ trans("front.no") }}</a></li>
                                    <li><a href="{{ URL::action('EventsController@isGoing', ['event' => $event->id, 'answer' => 'maybe']) }}">{{ trans("front.maybe") }}</a></li>
                                </ul>

                            </div>
                            @else
                                <a style="margin:0 5px" class="btn btn-primary " href="{{ URL::action('EventsController@isGoing', ['event' => $event->id, 'answer' => 'yes']) }}">{{ trans("front.yes") }}</a>
                                <a style="margin:0 5px" class="btn btn-primary " href="{{ URL::action('EventsController@isGoing', ['event' => $event->id, 'answer' => 'no']) }}">{{ trans("front.no") }}</a>
                                <a style="margin:0 5px" class="btn btn-primary " href="{{ URL::action('EventsController@isGoing', ['event' => $event->id, 'answer' => 'maybe']) }}">{{ trans("front.maybe") }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @else

            @if($event->date)
                <div class="row">
                    <div class="col-xs-12">
                        <div class="white-box">
                            <h4>{{ trans("front.eventEnded") }}</h4>
                        </div>
                    </div>
                </div>
            @endif

        @endif

            @if($event->hasImages())
                <div class="row">
                    <div class="col-xs-12">
                        <div class="white-box" style="padding-left: 0;padding-right: 0;">
                            <div class="col-xs-12">
                                <h4 style="margin-top: 0;margin-bottom: 15px;">{{ trans("front.eventImages") }}
                                    <span style="font-size: 80%;" class="pull-right"><small><a href="{{ URL::action('ImagesController@index', $event->id) }}">{{ trans("front.seeall") }} ({{ $event->countImages() }})</a></small></span>
                                </h4>
                            </div>
                            @foreach($event->getImages() as $image)
                                <div class="col-xs-6">
                                    <a href="{{ URL::action('ImagesController@show', $image->id) }}">
                                        <img src="{{ $image->getImage() }}" alt="Image" width="100%"/>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-xs-12">
                    <div class="white-box">

                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
                        <div class="addthis_native_toolbox"></div>
                        <br/>

                        <h4>{{ trans("front.eventDetails") }}</h4>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="event-author">
                                    {{ trans("front.author") }} <a href="{{ URL::action('UsersController@show', $event->user()->first()->username) }}">{{ $event->user->getFullname() }}</a> -
                                    @if($event->type == "private")
                                        {{ trans("front.privateEvent") }}
                                    @elseif($event->type == "public")
                                        {{ trans("front.publicEvent") }}
                                    @endif
                                </label>
                                <hr/>
                            </div>
                        </div>

                        <div class="row">
                            @if($event->date)
                            <div class="col-xs-12">
                                <i class="fa fa-calendar"></i> <label>{{ localDate($event->date) }}</label> - <label
                                        >{{ substr($event->time, 0, 2) }}:{{ substr($event->time, 2) }}</label>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-xs-12">

                                <label>
                                    @if($event->city)
                                        <i class="fa fa-map-marker"></i>
                                        {{ $event->city }}
                                    @else
                                        @if($event->country)
                                            <i class="fa fa-map-marker"></i>
                                            {{ $event->country }}
                                        @endif
                                    @endif
                                </label>
                            </div>
                        </div>

                        @if($event->lat && $event->lng)
                            {!! HTML::script("js/gmap.js") !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="map"><img/></div>
                                </div>

                                <script>

                                    url = GMaps.staticMapURL({
                                      size: [370, 300],
                                      lat: {{ $event->lat }},
                                      lng: {{ $event->lng }},
                                      markers: [
                                        {lat: {{ $event->lat }}, lng: {{ $event->lng }}}
                                      ]
                                    });

                                    $('#map img').attr('src', url)
                                      .appendTo('#map');
                                </script>
                            </div>
                        @endif

                        <br/>
                        <p class="event-description">{{ $event->description }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="white-box">
                        <h4>{{ trans("front.guests") }}
                            @if(Auth::user() && (Auth::user()->id == $event->user_id || $event->guestCanInvite))
                                @if(!(strtotime($event->date) < strtotime(date('Y-m-d'))))
                                    <button class="pull-right btn btn-primary btn-sm invite-users-button" data-url="{{ URL::action('EventsController@loadInviteModal') }}">{{ trans("front.invite") }}</button>
                                @endif
                            @endif

                            @if(Auth::user() and Auth::user()->id == $event->user_id)
                                <button class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#massMessage">{{ trans("front.message") }}</button>
                            @endif
                        </h4>

                        @if(count($event->going))
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="text-muted"><small>{{ trans("front.areGoing") }} ({{ count($event->going) }})</small></span>
                                    <hr class="lowHR"/>
                                    
                                    @foreach($event->going as $g)
                                        <div class="singleUser">
                                            <a href="{{ URL::action('UsersController@show', $g->username) }}" data-toggle="tooltip" data-placement="top" data-original-title="{{ $g->getFullname() }}">
                                                <img src="{{ $g->getAvatar() }}" alt="Avatar"/>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(count($event->maybegoing))
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="text-muted"><small>{{ trans("front.maybe") }} ({{ count($event->maybegoing) }})</small></span>
                                    <hr class="lowHR"/>

                                    @foreach($event->maybegoing as $g)
                                        <div class="singleUser">
                                            <a href="{{ URL::action('UsersController@show', $g->username) }}" data-toggle="tooltip" data-placement="top" data-original-title="{{ $g->getFullname() }}">
                                                <img src="{{ $g->getAvatar() }}" alt="Avatar"/>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(count($event->notgoing))
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="text-muted"><small>{{ trans("front.notGoing") }} ({{ count($event->notgoing) }})</small></span>
                                    <hr class="lowHR"/>

                                    @foreach($event->notgoing as $g)
                                        <div class="singleUser">
                                            <a href="{{ URL::action('UsersController@show', $g->username) }}" data-toggle="tooltip" data-placement="top" data-original-title="{{ $g->getFullname() }}">
                                                <img src="{{ $g->getAvatar() }}" alt="Avatar"/>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br/><br/>

    <script>
    $(document).ready(function(){

        var url = $(".post-input").attr("data-url");

        var users = null;
        $.post(url, null, function(data){
            users = data;

            $('.post-input').suggest('@', {

                data: users,
                map: function(user) {
                    return {
                        value: user.username,
                        text: '<strong>'+user.username+'</strong> <small>'+user.fullname+'</small>'
                    }
                }
            });
        }, "json");



        $('.singleUser a').tooltip({placement: 'top'});

        var url = "{{ URL::action('PostsController@uploadImage') }}";

        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            always: function(e, data){
                $(".image-loader").fadeOut(500);

                $(".event-image-holder div").html("<img src='/uploads/"+data.result.message+"'>");
                $(".image-path").val(data.result.message);
                $(".event-image-holder").show();
                $(".post-input").parent().removeClass("col-xs-7").addClass("col-xs-10");
                $(".upload-image").hide();

                $(".comment-buttons").fadeIn(200);
                $(".post-submit").attr("disabled", false);
            },
            start: function(e) {
                $(".image-loader").fadeIn(100);
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);

                $("#percent").html(progress + "%");
            }
        }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>

@endsection