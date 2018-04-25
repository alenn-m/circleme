@include('js-localization::head')

<html lang="en">
<head>

    @include("layouts.partials.head")

</head>
<body ondrop="return false;" style="background-color: black;">

<div class="container-fluid">

 <div class="row">
     <div class="col-md-9 col-xs-12" style="text-align: center;height:100%;">
         <div class="row">
             <div class="col-xs-12">
                 <a href="{{ URL::action("EventsController@show", $post->event->id) }}" class="pull-right image-close-button"><i class="fa fa-times"></i></a>
             </div>
         </div>
         <div class="row">
             <div class="col-xs-12">
                 {!! HTML::image($post->getImage(), "Image", ["style" => "margin-top:50px;max-width:100%;"]) !!}
             </div>
         </div>

         <div class="row bottom-navigation">
             <div class="col-xs-12">
                 @if($previous)
                    <a href="{{ URL::action("ImagesController@show", $previous) }}"><i class="fa fa-arrow-left"></i></a>
                 @endif
                 <span>{{ $position }} {{ trans("front.of") }} {{ $total }}</span>
                 @if($next)
                     <a href="{{ URL::action("ImagesController@show", $next) }}"><i class="fa fa-arrow-right"></i></a>
                 @endif
             </div>
         </div>
     </div>

     <div class="col-md-3 col-xs-12" style="background-color: #F5F5F5;height:100%;">
        <div class="row sidebar topside">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-3" style="text-align: center">
                        <a href="{{ URL::action('UsersController@show', $post->user->username) }}">{!! HTML::image($post->user->getAvatar(), "User", ["class" => "event-avatar"]) !!}</a>
                    </div>
                    <div class="col-xs-9">
                        <div class="row">
                            <div class="col-xs-12">
                                <h6 style="margin-top:0px"><a href="{{ URL::action('UsersController@show', $post->user->username) }}">{{ $post->user->getFullname() }}</a></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                        <span class="small text-muted">
                            <label>{{ nicetime($post->created_at) }}</label>
                        </span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($post->body)
                    <br/>
                    <div class="row">
                        <div class="col-xs-12">
                            <p style="margin-bottom:0;">{{ $post->body }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

         <div class="row">
             <div class="col-xs-12">
                 <br/>
                 @include("events.partials.comments")

                 @if(Auth::user())
                     {!! Form::open(["url" => URL::action("CommentsController@store"), "class" => "comment-form"]) !!}

                     {!! Form::text("comment", null, ["placeholder" => trans("front.addComment"), "class" => "form-control comment-input"]) !!}
                     {!! Form::hidden("post_id", $post->id) !!}
                 @endif

                 <div class="comment-buttons">
                     {!! Form::submit(trans("front.publishComment"), ["class" => "btn btn-success btn-sm comment-submit", "disabled"]) !!}
                     <a class="btn btn-default btn-sm comment-cancel">{{ trans("front.cancel") }}</a>
                 </div>
                 {!! Form::close() !!}
             </div>
         </div>
     </div>
 </div>

</div>




{!! Minify::javascript(["/js/bootstrap.min.js", "/js/salvattore.js"]) !!}

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

</body>
</html>