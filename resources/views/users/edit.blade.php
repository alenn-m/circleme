@extends("layouts.main")

@section("content")

<div class="col-xs-12 white-box" style="margin-top: 0;">

    <h1 style="margin-top:0;margin-bottom:10px;"><small>{{ trans("front.editProfile") }}</small></h1>

    <br>

    {!! Form::open(["url" => URL::action("UsersController@update", $user->id), "method" => "PUT"]) !!}

    <div class="form-group">
        <label for=""><strong>{{ trans("front.fullName") }}</strong></label>
        {!! Form::text("fullname", $user->fullname, ["class" => "form-control", "placeholder" => trans("front.fullName")]) !!}
    </div>

    <div class="form-group">
        <label for=""><strong>{{ trans("front.location") }}</strong></label>
        {!! Form::text("location", $user->location, ["class" => "form-control", "placeholder" => trans("front.location")]) !!}
    </div>

    <div class="form-group">
        {!! Form::checkbox("showmail", true, $user->showmail) !!}
        <label for=""><strong>{{ trans("front.showMailOnProfile") }}</strong></label>
    </div>

    <div class="form-group">
        <label for=""><strong>{{ trans("front.about") }}</strong></label>
        {!! Form::textarea("about", $user->about, ["class" => "form-control", "rows" => "7", "placeholder" => trans("front.about")]) !!}
    </div>

    {!! Form::submit(trans("front.save"), ["class" => "btn btn-primary"]) !!}

    {!! Form::close() !!}
</div>

@endsection