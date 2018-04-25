@extends("layouts.wide")

@section("content")

    {!! Minify::stylesheet("/css/social.css") !!}

    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <h1 class="text-center login-title">{{ trans("front.signIn") }}</h1>
                <div class="account-wall" style="text-align: center">
                    {!! Form::open(["url" => URL::action("UsersController@postLogin"), "class" => "form-signin"]) !!}

                    <div class="no-cookie">
                        @if(!Cookie::get("user"))
                            <img class="profile-img" src="/img/nouser.png" alt="">
                            {!! Form::text("username", null, ["placeholder" => trans("front.username"), "class" => "form-control"]) !!}
                        @endif
                    </div>

                    <div class="has-cookie">
                        @if(Cookie::get("user"))
                            {!! HTML::image(Cookie::get("user")["image"], "Image", ["style" => "width:100px;height:100px;border-radius:100%;"]) !!}
                            {!! Form::hidden("username", Cookie::get("user")["username"]) !!}

                            <h5 style="text-align: center">{{ Cookie::get("user")["name"] }}</h5>
                        @endif
                    </div>

                    {!! Form::password("password", ["placeholder" => trans("front.password"), "class" => "form-control"]) !!}

                    <button class="btn btn-lg btn-primary btn-block" type="submit">{{ trans("front.login") }}</button>


                    <label class="checkbox pull-left rememberBox" @if(Cookie::get("user")) style="display:none" @endif>
                        <input type="checkbox" value="true" name="remember">
                        {{ trans("front.rememberMe") }}
                    </label>

                    <div class="clearfix"></div>

                    @if(hasAnySocial())
                        <h5>{{ trans("front.orLoginWith") }}</h5>

                        @if(hasSocial("facebook"))
                            <a href="{{ URL::action('SocialLoginController@social', "facebook") }}" class="btn btn-social-icon btn-social btn-facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                        @endif

                        @if(hasSocial("twitter"))
                            <a href="{{ URL::action('SocialLoginController@social', "twitter") }}" class="btn btn-social-icon btn-social btn-twitter">
                                <i class="fa fa-twitter"></i>
                            </a>
                        @endif

                        @if(hasSocial("google"))
                            <a href="{{ URL::action('SocialLoginController@social', "google") }}" class="btn btn-social-icon btn-social btn-google">
                                <i class="fa fa-google"></i>
                            </a>
                        @endif
                    @endif

                    {!! Form::close() !!}

                </div>
                @if(Cookie::get("user"))
                    <button data-url="{{ URL::action('UsersController@clearLogin') }}" class="text-center new-account clear-account btn-link" style="width:100%;">{{ trans("front.loginWithAnotherAccount") }}</button>
                @endif
            </div>
        </div>
        <br/>

        @if(Session::has("message"))
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <br/>
                    <div class="alert alert-warning" style="text-align: center">
                        {{ Session::get("message") }}
                    </div>
                    <br/><br/>
                </div>
            </div>

        @endif
    </div>



@endsection