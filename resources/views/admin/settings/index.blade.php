@extends("admin.settings.main")

@section("settings")

    <div class="row">
        <div class="col-xs-6">
        {!! Form::open(["files" => true, "url" => URL::action("Admin\SettingsController@store")]) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label for="">{{ trans("admin.siteLogo") }} (110x30)</label>
                    </div>

                    <div class="col-xs-8">
                        @if(Config::get("settings.logo"))
                        <div class="row">
                            <div class="col-xs-12">
                                {!! HTML::image("/uploads/" . Config::get("settings.logo"), "Logo", ["width" => "110", "height" => "30", "class" => "site-logo"]) !!}
                                <a class="btn btn-warning btn-xs use_text_button">{{ trans("admin.useTextLogo") }}</a>
                            </div>
                        </div>
                        <br/>
                        @endif
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::hidden("use_text", null, ["class" => "use_text_field"]) !!}
                                {!! Form::file("logo") !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label for="">{{ trans("admin.siteTitle") }}</label>
                    </div>

                    <div class="col-xs-8">
                        {!! Form::text("title", Config::get("settings.title"), ["class" => "form-control"]) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label for="">{{ trans("admin.siteURL") }}</label>
                    </div>

                    <div class="col-xs-8">
                        {!! Form::text("url", Config::get("settings.url"), ["class" => "form-control"]) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label for="">{{ trans("admin.keywords") }}</label>
                    </div>

                    <div class="col-xs-8">
                        {!! Form::text("keywords", Config::get("settings.keywords"), ["class" => "form-control"]) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label for="">{{ trans("admin.siteDescription") }}</label>
                    </div>

                    <div class="col-xs-8">
                        {!! Form::textarea("description", Config::get("settings.description"), ["class" => "form-control", "rows" => "3"]) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label for="">{{ trans("admin.eventsPerPage") }}</label>
                    </div>

                    <div class="col-xs-8">
                        {!! Form::input("number", "eventsPerPage", Config::get("settings.eventsPerPage"), ["class" => "form-control"]) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label for="">{{ trans("admin.postsPerPage") }}</label>
                    </div>

                    <div class="col-xs-8">
                        {!! Form::input("number", "postsPerPage", Config::get("settings.postsPerPage"), ["class" => "form-control"]) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label for="">{{ trans("admin.messagesPerPage") }}</label>
                    </div>

                    <div class="col-xs-8">
                        {!! Form::input("number", "messagesPerPage", Config::get("settings.messagesPerPage"), ["class" => "form-control"]) !!}
                    </div>
                </div>
            </div>

            {!! Form::submit(trans("admin.save"), ["class" => "btn btn-success"]) !!}

        {!! Form::close() !!}
        </div>
    </div>

@endsection