@extends("layouts.main")

@section("content")

    @if(Auth::user() and Auth::user()->id == $user->id)
        {!! Minify::stylesheet("/css/jquery.fileupload.css") !!}
        {!! Minify::javascript(["/js/jquery.fileupload.js", "/js/b-draggable.js"]) !!}
    @endif


    
    <div class="image-reposition cover-wrap">

        <div class="row dragMe-div">
            <div class="col-xs-12">
                <span>
                    {{ trans("front.dragToReposition") }}
                </span>
            </div>
        </div>

        <img src="" class="reposition-cover" width="100%" style="position:absolute;top:0;"/>

        <div class="bottom-options">
            {!! Form::open(["url" => URL::action("UsersController@updatePosition"), "class" => "updatePositionForm"]) !!}
                {!! Form::hidden("cover_position", $user->background_position, ["class" => "cover-position"]) !!}

                {!! Form::submit(trans("front.save"), ["class" => "btn btn-primary updatePositionSubmit"]) !!}
                <a href="{{ URL::action('UsersController@show', $user->username) }}" class="btn btn-default updatePositionCancel">{{ trans("front.cancel") }}</a>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="row user-info-background" style="background-image:url('{{ $user->getBackground() }}');background-position: 0 {{ $user->background_position }}px">

            <div class="alert alert-danger image-error">
                <a style="line-height:10px;" href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ trans("front.minimumImageDimensions") }} (600x350 px)
            </div>

        <div class="col-md-4 col-xs-6" style="background-color: rgba(0,0,0,0.7);height:270px;">
            <div class="row">
                <div class="col-xs-12 user-avatar-profile" style="position: relative;">
                    {!! HTML::image($user->getAvatar(), $user->getFullname()) !!}

                    @if(Auth::user() && Auth::user()->id == $user->id)
                        <span class="fileinput-button newAvatarButton">
                            <i class="fa fa-camera"></i>
                            <input id="fileupload2" type="file" name="file">
                        </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h5 class="user-name-profile">{{ $user->getFullname() }}</h5>
                </div>
            </div>

            @if(Auth::user() and $user->id != Auth::user()->id)
                <div class="row">
                    <div class="col-xs-12">
                        <select multiple id="circleoption" data-url="{{ URL::action('CirclesController@addUser') }}" data-user="{{ $user->id }}">
                            @if(isset($circles))
                                @foreach($circles as $circle)
                                    <option @if(in_array($circle->id, $belongsTo)) selected @endif value="{{ $circle->id }}">{{ $circle->name }}</option>
                                @endforeach
                            @endif
                        </select>

                        <a href="{{ URL::route('conversation-create', $user->username) }}" class="btn btn-primary btn-sm contact"><i class="fa fa-envelope-o"></i></a>
                    </div>
                </div>
            @endif
        </div>

        @if(Auth::user() && Auth::user()->id == $user->id)
            <div class="col-md-8 col-xs-6 user-top-right">
                <div class="row">
                    <div class="col-xs-12">
                        <br/>

                        <div class="btn-group pull-right">
                            <button type="button" class="changeBackgroundWrap btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-camera"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#" class="fileinput-button">
                                        {{ trans("front.changeBackground") }}
                                        <input id="fileupload" type="file" name="file">
                                    </a>
                                </li>
                                <li><a class="repositionTrigger">{{ trans("front.repositionImage") }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        @if($user->about)
            <div class="col-md-6 col-sm-12">
                <div class="white-box box-blue">
                    <h4>
                        {{ trans("front.info") }}
                        @if(Auth::user() and Auth::user()->id == $user->id)
                        <span>
                            <small>
                                <a style="font-size: 70%;" href="{{ URL::action('UsersController@edit', Auth::user()->id) }}">
                                    {{ trans("front.editProfile") }}
                                </a>
                            </small>
                        </span>
                        @endif
                    </h4>
                    @if($user->showmail and $user->email)
                        <label style="font-weight: bold"><span class="text-muted">{{ trans("front.email") }}: </span> <span>{{ $user->email }}</span></label>
                        <br/>
                    @endif

                    @if($user->location)
                        <label style="font-weight: bold"><span class="text-muted">{{ trans("front.location") }}: </span> <span>{{ $user->location }}</span></label>
                        <br/>
                    @endif

                    <label style="font-weight: bold"><span class="text-muted">{{ trans("front.joined") }}: </span> <span>{{ localDate($user->created_at) }}</span></label>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 ">
                <div class="white-box box-green">
                    <h4>{{ trans("front.about") }}</h4>

                    <p class="about">{{ $user->about }}</p>

                </div>
            </div>
        @else
            <div class="col-sm-12">
                <div class="white-box box-blue">
                    <h4>
                        {{ trans("front.info") }}
                        @if(Auth::user()->id == $user->id)
                            <span>
                            <small>
                                <a style="font-size: 70%;" href="{{ URL::action('UsersController@edit', $user->id) }}">
                                    {{ trans("front.editProfile") }}
                                </a>
                            </small>
                        </span>
                        @endif
                    </h4>
                    @if($user->showmail and $user->email)
                        <label style="font-weight: bold"><span class="text-muted">{{ trans("front.email") }}: </span> <span>{{ $user->email }}</span></label>
                        <br/>
                    @endif

                    @if($user->location)
                        <label style="font-weight: bold"><span class="text-muted">{{ trans("front.location") }}: </span> <span>{{ $user->location }}</span></label>
                        <br/>
                    @endif

                    <label style="font-weight: bold"><span class="text-muted">{{ trans("front.joined") }}: </span> <span>{{ localDate($user->created_at) }}</span></label>
                </div>
            </div>
        @endif
    </div>

    <br/>

    <div class="row profile-events">
        @include("layouts.partials.loadEvents")
    </div>

    <script>
        $(document).ready(function(){

            $('#circleoption').multiselect({
                buttonText : function(options, select){
                @if(count($belongsTo) == 0)
                    return "<i class='fa fa-user-plus'></i> {{ trans('front.addToCircle') }}";
                @elseif(count($belongsTo) == 1)
                    return "<i class='fa fa-circle-o'></i> {{ \App\Http\Models\Circle::find($belongsTo[0])->name }}";
                @else
                    return "<i class='fa fa-circle-o'></i> {{ count($belongsTo) . ' ' . trans('front.circles') }}";
                @endif
                },
                enableHTML: true,
                @if(count($belongsTo) == 0)
                    buttonClass: "btn btn-danger btn-sm",
                @else
                    buttonClass: "btn btn-default btn-sm",
                @endif
                disableIfEmpty: true,
                onChange: function(option, checked, select) {
                    var url = $("#circleoption").attr("data-url");
                    var user = $("#circleoption").attr("data-user");
                    var circle = $(option).val();

                    $.post(url, {"user" : user, "circle" : circle, "remove" : !checked}, function(data){
                        console.log(data);
                    }, "json");
                }
            });

            $(".multiselect").find(".caret").remove();
        });
    </script>

    @if(Auth::user() and Auth::user()->id == $user->id)

        {!! HTML::script("/js/nanobar.min.js") !!}

        <script>
            $(document).ready(function(){

                var url = "{{ URL::action('UsersController@uploadBackground') }}";
                var url2 = "{{ URL::action('UsersController@uploadAvatar') }}";

                var options = {
                    bg: '#e74c3c',
                    id: 'mynano'
                };

                var nanobar = new Nanobar( options );

                var checkSize = function(width, height){
                    if(width < 600 || height < 350){
                        $(".image-error").fadeIn(200);
                    }else{
                        $(".image-error").fadeOut(100);
                    }
                }

                $('#fileupload').fileupload({
                    url: url,
                    dataType: 'json',
                    always: function(e, data){
                        if(data.result.size == "ok"){
                            $(".user-info-background").css("background-image", "url('/backgrounds/"+data.result.message+"')");
                            $(".dragMe-div").fadeIn(200);

                            $(".reposition-cover").attr("src", "/backgrounds/"+data.result.message);
                            $(".cover-wrap").fadeIn(200);

                            $(".user-info-background").hide();

                            $(".reposition-cover").draggable({
                                scroll: false,
                                axis: "y",
                                drag: function (event, ui) {
                                    y1 = $('.cover-wrap').height();
                                    y2 = $('.reposition-cover').height();

                                    if (ui.position.top >= 0) {
                                        ui.position.top = 0;
                                    }
                                    else
                                        if (ui.position.top <= (y1-y2)) {
                                            ui.position.top = y1-y2;
                                        }
                                    },

                                    stop: function(event, ui) {
                                        $('.cover-position').val(ui.position.top);
                                    }
                            });

                            $(".image-error").fadeOut(200);
                        }else if(data.result.size == "error"){
                            $(".image-error").fadeIn(200);

                            setTimeout(function(){
                                $(".image-error").fadeOut(200);
                            }, 5000);
                        }

                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        nanobar.go(progress);
                    }
                }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');

                $('#fileupload2').fileupload({
                    url: url2,
                    dataType: 'json',
                    always: function(e, data){
                        $(".user-avatar-profile img").attr("src", "/avatars/"+data.result.message);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        nanobar.go(progress);
                    }
                }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');


            });
        </script>

    @endif


@endsection