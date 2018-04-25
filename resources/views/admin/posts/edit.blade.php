@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h2 class="top-heading">{{ trans("admin.editPost") }}</h2>
        </div>
    </div>
    <br/>

    {!! Form::open(["url" => URL::action("Admin\PostsController@update", $post->id), "method" => "put"]) !!}

        <div class="form-group">
            <label for="">{{ trans("admin.event") }}</label>
            {!! Form::text("event", $post->event->title, ["class" => "form-control", "disabled"]) !!}
        </div>

        <div class="form-group">
            <label for="">{{ trans("admin.post") }}</label>
            {!! Form::textarea("body", $post->body, ["class" => "form-control"]) !!}
        </div>

        @if(!is_empty($post->image))
            <div class="form-group">
                <label for="">{{ trans("admin.image") }}</label>
                {!! HTML::image($post->image, "Image", ["width" => "256"]) !!}
                <label for="">{{ trans("admin.uploadNewImage") }}</label>
                {!! Form::file("image") !!}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <label for="">{{ $error }}</label><br/>
                @endforeach
            </div>
        @endif

        {!! Form::submit(trans("admin.update"), ["class" => "btn btn-success"]) !!}
        <a href="{{ URL::action('Admin\PostsController@index') }}" class="btn btn-default">{{ trans("admin.cancel") }}</a>


    {!! Form::close() !!}

@endsection