@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h2 class="top-heading">{{ trans("admin.editComment") }}</h2>
        </div>
    </div>
    <br/>

    {!! Form::open(["url" => URL::action("Admin\CommentsController@update", $comment->id), "method" => "put"]) !!}

        <div class="form-group">
            {!! Form::hidden("post_id", $comment->post_id) !!}
            <label for="">{{ trans("admin.comment") }}</label>
            {!! Form::text("comment", $comment->comment, ["class" => "form-control"]) !!}
        </div>

        {!! Form::submit(trans("admin.update"), ["class" => "btn btn-success"]) !!}
        <a href="{{ URL::action('Admin\CommentsController@index') }}" class="btn btn-default">{{ trans("admin.cancel") }}</a>


    {!! Form::close() !!}

@endsection