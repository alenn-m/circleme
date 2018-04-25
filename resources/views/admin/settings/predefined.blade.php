@extends("admin.settings.main")

@section("settings")

@if(Session::has("message"))
    <div class="row">
        <div class="col-md-9 col-xs-12">
            <div class="alert alert-success">
                {{ Session::get("message") }}
            </div>
        </div>
    </div>
@endif

{!! Form::open(["url" => URL::action("Admin\SettingsController@storePredefinedEmail")]) !!}

<div class="row">
    <div class="col-md-9 col-xs-12">
        <div class="form-group">
            <label for="">{{ trans("admin.confirmEmail") }}</label>
            {!! Form::textarea("confirmEmail", $confirmEmail, ["class" => "form-control"]) !!}
        </div>
        <hr/>

        <div class="form-group">
            <label for="">{{ trans("admin.contact") }}</label>
            {!! Form::textarea("contact", $contact, ["class" => "form-control"]) !!}
        </div>
        <hr/>

        <div class="form-group">
            <label for="">{{ trans("admin.forgotPassword") }}</label>
            {!! Form::textarea("forgotPassword", $forgotPassword, ["class" => "form-control"]) !!}
        </div>
        <hr/>

        <div class="form-group">
            <label for="">{{ trans("admin.invite") }}</label>
            {!! Form::textarea("invite", $invite, ["class" => "form-control"]) !!}
        </div>
        <hr/>

        <div class="form-group">
            <label for="">{{ trans("admin.validateEmail") }}</label>
            {!! Form::textarea("validateEmail", $validateEmail, ["class" => "form-control"]) !!}
        </div>
        <hr/>

        {!! Form::submit(trans("front.save"), ["class" => "btn btn-success"]) !!}
    </div>
</div>


{!! Form::close() !!}

@endsection