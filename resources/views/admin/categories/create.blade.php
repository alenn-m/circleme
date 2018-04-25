@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h2 class="top-heading">{{ trans("admin.newCategory") }}</h2>
        </div>
    </div>
    <br/>

    {!! Form::open(["url" => URL::action("Admin\CategoriesController@store")]) !!}

    <div class="form-group">
        <label for="">{{ trans("admin.name") }}</label>
        {!! Form::text("name", null, ["class" => "form-control"]) !!}
    </div>

    {!! Form::submit(trans("admin.save"), ["class" => "btn btn-success"]) !!}
    <a href="{{ URL::action('Admin\CategoriesController@index') }}" class="btn btn-default">{{ trans("admin.cancel") }}</a>


    {!! Form::close() !!}

@endsection