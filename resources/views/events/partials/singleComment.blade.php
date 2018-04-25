<div class="row singleComment" id="{{ $comment->id }}">

    <div class="col-xs-2" style="text-align: center;">
        {!! HTML::image($comment->user->getAvatar(), "User", ["width" => "32", "height" => "32"]) !!}
    </div>

    <div class="col-xs-10" style="padding-left: 0 !important;">
        <div class="row">
            <div class="col-xs-12">
                <strong>{{ $comment->user->username }}</strong>
                <span class="text-muted">{{ nice_date($comment->created_at) }}</span>
            </div>
        </div>

        <div class="row comment-text">
            <div class="col-xs-12">
                {{ $comment->comment }}
            </div>
        </div>

        @if(Auth::user() && Auth::user()->id == $comment->user_id)
            <div class="comment-options">
                <button class="btn-link comment-edit" data-url="{{ URL::action('CommentsController@edit', $comment->id) }}">{{ trans("front.edit") }}</button>
                <button class="btn-link comment-delete" data-url="{{ URL::action('CommentsController@delete', $comment->id) }}"><i class="fa fa-times-circle"></i></button>
            </div>
        @endif
    </div>

    <div class="col-xs-10 comment-edit-form" style="padding-left: 0 !important;">
        {!! Form::open(["url" => URL::action("CommentsController@update", $comment->id), "class" => "comment-edit-form", "method" => "PUT"]) !!}

        {!! Form::text("comment", null, ["placeholder" => trans("front.addComment"), "class" => "form-control comment-edit-input", "autocomplete" => "off"]) !!}
        {!! Form::hidden("post_id", $post->id) !!}

        {!! Form::submit(trans("front.update"), ["class" => "btn btn-success btn-sm comment-update"]) !!}
        <a style="margin-top:10px;" class="btn btn-default btn-sm comment-edit-cancel">{{ trans("front.cancel") }}</a>

        {!! Form::close() !!}
    </div>

</div>

<hr/>