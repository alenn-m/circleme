@extends("admin.settings.main")

@section("settings")

    {!! Form::open(["url" => URL::action("Admin\SettingsController@storeEmail")]) !!}
    <div class="row">
        <div class="col-xs-6">

            <div class="form-group">
                <label for="">{{ trans("admin.sendDriver") }}</label>
                <select name="driver" id="" class="form-control">
                    <option value="sendmail" @if(Config::get("mail.driver") == "sendmail") selected @endif>Sendmail</option>
                    <option value="mandrill" @if(Config::get("mail.driver") == "mandrill") selected @endif>Mandrill</option>
                </select>
            </div>

            <div class="form-group">
                <label for="">{{ trans("admin.yourName") }}</label>
                {!! Form::text("name", Config::get("mail.from.name"), ["class" => "form-control"]) !!}
            </div>

            <div class="form-group">
                <label for="">{{ trans("admin.yourEmail") }}</label>
                {!! Form::text("address", Config::get("mail.from.address"), ["class" => "form-control"]) !!}
            </div>

            <hr/>

            <h2><small>{{ trans("admin.mandrilConnection") }}</small></h2>

            <div class="form-group">
                <label for="">{{ trans("admin.api_key") }}</label>
                {!! Form::text("mandril_api", Config::get("services.mandrill.secret"),["class" => "form-control"]) !!}
            </div>

            {!! Form::submit(trans("admin.save"), ["class" => "btn btn-success"]) !!}

        </div>
    </div>
    {!! Form::close() !!}

@endsection