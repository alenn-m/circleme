@extends("admin.settings.main")

@section("settings")

    <div class="row">
        <div class="col-xs-6">
            {!! Form::open(["url" => URL::action("Admin\SettingsController@store")]) !!}

            <div class="form-group">
                <label for="">{{ trans("admin.top") }}</label>
                {!! Form::textarea("ad1", Config::get("settings.ad1"), ["class" => "form-control"]) !!}
            </div>

            <div class="form-group">
                <label for="">{{ trans("admin.topSidebar") }}</label>
                {!! Form::textarea("ad2", Config::get("settings.ad2"), ["class" => "form-control"]) !!}
            </div>

            <div class="form-group">
                <label for="">{{ trans("admin.centerEvent") }}</label>
                {!! Form::textarea("ad3", Config::get("settings.ad3"), ["class" => "form-control"]) !!}
            </div>

            {!! Form::submit(trans("admin.save"), ["class" => "btn btn-success"]) !!}

            {!! Form::close() !!}

        </div>
    </div>

@endsection