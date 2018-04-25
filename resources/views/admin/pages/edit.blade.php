@extends("admin.layouts.main")

@section("content")

    {!! HTML::script("/ckeditor/ckeditor.js") !!}

    <div class="row">
        <div class="col-xs-12">
            <h2 class="top-heading">{{ trans("admin.pages") }}</h2>
        </div>
    </div>
    <br/>

    {!! Form::open(["url" => URL::action("Admin\PagesController@update", $page->id), "method" => "put"]) !!}

    <div class="row">
        <div class="col-xs-8">
            <div class="form-group">
                {!! Form::text("short_title", $page->short_title, ["placeholder" => trans("admin.short_title"), "class" => "form-control"]) !!}
            </div>

            <div class="form-group">
                {!! Form::text("title", $page->title, ["placeholder" => trans("admin.title"), "class" => "form-control"]) !!}
            </div>

            <div class="form-group">
                {!! Form::textarea("body", $page->body, ["placeholder" => trans("admin.body"), "class" => "form-control ckeditor"]) !!}
            </div>

            {!! Form::submit(trans("admin.update"), ["class" => "btn btn-success"]) !!}
        </div>
    </div>

    {!! Form::close() !!}

    @if($errors->any())
        <br/>
        <div class="row" style="text-align: center;">
            <div class="col-xs-8">
                <div class="alert alert-warning">
                    @foreach($errors->all() as $error)
                        <label for="">{{ $error }}</label><br/>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

@endsection