@extends("admin.settings.main")

@section("settings")

    {!! Form::open(["url" => URL::action("Admin\SettingsController@storeServices")]) !!}

    <div class="row">
        <div class="col-xs-6">
            <h2 style="margin-top: 0"><small>Facebook</small></h2>
            <div class="form-group">
                <label for="">{{ trans("admin.client_id") }}</label>
                {!! Form::text("facebook-client_id", Config::get("services.facebook.client_id"), ["class" => "form-control"]) !!}
            </div>

            <div class="form-group">
                <label for="">{{ trans("admin.secret_id") }}</label>
                {!! Form::text("facebook-client_secret", Config::get("services.facebook.client_secret"), ["class" => "form-control"]) !!}
            </div>
            {!! Form::hidden("facebook-redirect", Request::root() . "login/facebook") !!}
        </div>
    </div>

    <hr/>

    <div class="row">
        <div class="col-xs-6">
            <h2 style="margin-top: 0"><small>Google+</small></h2>
            <div class="form-group">
                <label for="">{{ trans("admin.client_id") }}</label>
                {!! Form::text("google-client_id", Config::get("services.google.client_id"), ["class" => "form-control"]) !!}
            </div>

            <div class="form-group">
                <label for="">{{ trans("admin.secret_id") }}</label>
                {!! Form::text("google-client_secret", Config::get("services.google.client_secret"), ["class" => "form-control"]) !!}
            </div>
            {!! Form::hidden("google-redirect", Request::root() . "login/google") !!}
        </div>
    </div>

    <hr/>

    <div class="row">
        <div class="col-xs-6">
            <h2 style="margin-top: 0"><small>Twitter</small></h2>
            <div class="form-group">
                <label for="">{{ trans("admin.client_id") }}</label>
                {!! Form::text("twitter-client_id", Config::get("services.twitter.client_id"), ["class" => "form-control"]) !!}
            </div>

            <div class="form-group">
                <label for="">{{ trans("admin.secret_id") }}</label>
                {!! Form::text("twitter-client_secret", Config::get("services.twitter.client_secret"), ["class" => "form-control"]) !!}
            </div>
            {!! Form::hidden("twitter-redirect", Request::root() . "login/twitter") !!}
        </div>
    </div>

    <hr/>

    <div class="row">
        <div class="col-xs-6">
            <h2 style="margin-top: 0"><small>Recaptcha</small></h2>
            <div class="form-group">
                <label for="">{{ trans("admin.client_id") }}</label>
                {!! Form::text("siteKey", Config::get("recaptcha.siteKey"), ["class" => "form-control"]) !!}
            </div>

            <div class="form-group">
                <label for="">{{ trans("admin.secret_id") }}</label>
                {!! Form::text("secretKey", Config::get("recaptcha.secretKey"), ["class" => "form-control"]) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <h2 style="margin-top: 0"><small>AddThis code</small></h2>
            <div class="form-group">
                {!! Form::textarea("addthis_code", Config::get("settings.addthis_code"), ["class" => "form-control"]) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <h2 style="margin-top: 0"><small>Google tracking code</small></h2>
            <div class="form-group">
                {!! Form::textarea("tracking_code", Config::get("settings.tracking_code"), ["class" => "form-control"]) !!}
            </div>
        </div>
    </div>

    {!! Form::submit(trans("admin.save"), ["class" => "btn btn-success"]) !!}

    {!! Form::close() !!}

@endsection