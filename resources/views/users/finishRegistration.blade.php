@extends("layouts.wide")

@section("content")

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="white-box">
                {!! Form::open(["url" => URL::action("SocialLoginController@finishRegistration", $user->id)]) !!}

                @if(!isset($user->email))
                    <div class="form-group">
                        {!! Form::text("email", null, ["placeholder" => trans("front.email"), "class" => "form-control"]) !!}
                    </div>
                @endif

                <div class="form-group">
                    @if(isset($user->email))
                        {!! Form::hidden("email", $user->email) !!}
                    @endif
                    {!! Form::text("username", null, ["placeholder" => trans("front.username"), "class" => "form-control"]) !!}
                </div>

                <button class="btn btn-lg btn-primary btn-block" type="submit">{{ trans("front.signIn") }}</button>

                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="row" style="text-align:center;">
                <div class="col-md-6 col-md-offset-3">
                    <div class="alert alert-warning">{{{ $error }}}</div>
                </div>
            </div>
        @endforeach
    @endif

    @if(Session::has("message"))
        <div class="row" style="text-align:center;">
            <div class="col-md-6 col-md-offset-3">
                <div class="alert alert-warning">{{{ Session::get("message") }}}</div>
            </div>
        </div>
    @endif

@endsection