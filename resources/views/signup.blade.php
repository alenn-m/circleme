@extends("layouts.wide")

@section("content")

{!! Form::open(["url" => URL::action("UsersController@postSignup"), "method" => "post"]) !!}

    <div class="col-md-6">
        <h3>{{ trans("front.registration") }}</h3>

        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="form-group col-lg-6">
                    {!! Form::text("username", null, ["class" => "form-control", "placeholder" => trans("front.username")]) !!}
                </div>

                <div class="form-group col-lg-6">
                    {!! Form::text("email", null, ["class" => "form-control", "placeholder" => trans("front.email")]) !!}
                </div>

                <div class="form-group col-lg-6">
                    {!! Form::password("password", ["class" => "form-control", "placeholder" => trans("front.password")]) !!}
                </div>

                <div class="form-group col-lg-6">
                    {!! Form::password("password_confirmation", ["class" => "form-control", "placeholder" => trans("front.confirmPassword")]) !!}
                </div>

                @if(hasRecaptcha())
                    <div class="col-xs-12">
                        {!! View::make('recaptcha::display') !!}
                    </div>
                @endif

                <div class="col-lg-12">
                    {!! Form::checkbox("terms", true) !!}
                    <label for="terms">{{ trans("front.acceptTerms") }}</label>
                    <br/><br/>
                </div>

                <div class="col-lg-12">
                    {!! Form::submit(trans("front.register"), ["class" => "btn btn-primary"]) !!}
                </div>

                @if($errors->any())
                    <div class="col-lg-12">
                        <br/>
                        <div class="alert alert-warning">
                            @foreach($errors->all() as $error)
                                <label>{{ $error }}</label><br/>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(Session::has("message"))
                    <div class="col-lg-12">
                        <br/>
                        <div class="alert alert-success">
                            <label>{{ Session::get("message") }}</label><br/>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <h3 class="dark-grey">{{ trans("front.termConditions") }}</h3>

        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>


    </div>

{!! Form::close() !!}

@endsection