@extends("layouts.main")

@section("content")

    <div class="white-box" style="margin-top: 0">
        <div class="row">
            <div class="col-xs-12">
                <h5 style="margin-top: 0">{{ trans("front.newMessage") }}</h5>
            </div>
        </div>

        <br/>

        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-2" style="text-align: center">
                        {!! HTML::image($user->getAvatar(), $user->username, ["width" => "64", "height" => "64"]) !!}
                    </div>

                    <div class="col-xs-10">
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="">Alen Mašić</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <span class="text-muted"><a href="{{ URL::action('UsersController@show', $user->username) }}">{{ $user->username }}</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>

        {!! Form::open(["url" => URL::action("ConversationsController@store")]) !!}
            <div class="form-group">
                {!! Form::hidden("user", $user->id) !!}
            </div>
            <div class="form-group">
                {!! Form::textarea("message", null, ["placeholder" => trans("front.message"), "class" => "form-control", "rows" => 5]) !!}
            </div>

            {!! Form::submit(trans("front.sendMessage"), ["class" => "btn btn-primary"]) !!}
            <a href="{{ URL::action('HomeController@home') }}" class="btn btn-default">{{ trans("front.cancel") }}</a>
        {!! Form::close() !!}



    </div>

@endsection