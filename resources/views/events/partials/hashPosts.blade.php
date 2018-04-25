@if(isset($posts) && count($posts) > 0)

    @foreach($posts as $post)

        <div class="row singlePost" id="{{ $post->id }}">
            <div class="col-xs-12">
                <div class="white-box" @if($post->image) style="padding-bottom: 0;" @endif>
                    <div class="row">
                        <div class="col-xs-2">
                            {!! HTML::image($post->user->getAvatar(), "User", ["class" => "event-avatar"]) !!}
                        </div>

                        <div class="col-xs-10">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label><strong>{{ $post->user->getFullname() }}</strong></label>

                                    @if(Auth::user() && Auth::user()->id == $post->user_id)
                                        <div class="dropdown pull-right">
                                            <button class="btn-link dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a style="cursor:pointer" class="event-post-edit">{{ trans("front.edit") }}</a></li>
                                                <li><a href="{{ URL::action('PostsController@delete', $post->id) }}">{{ trans("front.delete") }}</a></li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="text-muted"><small>{{ nice_date($post->created_at) }}</small></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="col-xs-12 event-body-original">
                            <p class="post-body">{!! getMentions($post->body) !!}</p>
                        </div>

                        @if(Auth::user() and Auth::user()->id == $post->user_id)
                            <div class="col-xs-12 event-body-new" style="display:none;">
                                {!! Form::open(["url" => URL::action('PostsController@update', $post->id), "method" => "PUT", "class" => "event-update-form"]) !!}
                                {!! Form::text("body", $post->body, ["class" => "form-control event-body-edit"]) !!}

                                <br/>

                                {!! Form::submit(trans("front.updatePost"), ["class" => "btn btn-success btn-sm post-update"]) !!}
                                <a class="btn btn-default btn-sm post-update-cancel">{{ trans("front.cancel") }}</a>

                                {!! Form::close() !!}
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <span class="text-muted">
                                <a style="color:#d3d3d3;" href="{{ URL::action('EventsController@show', $post->event->id . "#" . $post->id) }}">{{ $post->event->title }}</a>
                            </span>
                        </div>
                    </div>
                </div>

                @if($post->getImage())
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="{{ URL::action('ImagesController@show', $post->id) }}">
                                <img src="{{ $post->getImage() }}" alt="Image" width="100%"/>
                            </a>
                        </div>
                    </div>
                @endif



            </div>
        </div>

    @endforeach

    {!! $posts->render() !!}

    <script>
        $(".loadPosts").infinitescroll({
            navSelector     : ".pagination",
            nextSelector    : ".pagination a:last",
            itemSelector    : ".singlePost",
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
                finishedMsg: ""
            }
        }, function(newElements, data, url){

        });
    </script>

@endif