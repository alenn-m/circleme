@extends("layouts.main")

@section("content")

    <div class="col-xs-12 white-box" style="margin-top: 0;">
        {!! Form::open(["url" => URL::action("SettingsController@email"), "class" => "settingsForm", "role" => "form"]) !!}
        <h1 style="margin-top:0;margin-bottom:10px;"><small>{{ trans("front.changeSettings") }}</small></h1>

        <br>

        <div class="form-group">
            <h4>{{ trans("front.currentEmail") }}</h4>
        </div>

        <hr>

        <div class="form-group">
            <span id="settingsCurrentEmail">{{ $user->email }}</span>
            <a id="emailChangeButton" style="margin-left:10px;" class="btn btn-success btn-sm">{{ trans("front.change") }}</a>
            <input style='display:none' class="form-control" type="text" name="email" id="newEmail" placeholder={{ trans("front.email") }}><br>
            <input style='display:none' id="settingsMailSubmit" class="btn btn-submit btn-success" type="submit" value={{ trans("front.save") }}>
        </div>



        <div class="alert alert-warning" id="settingsEmailMessage">
            @if(isset($message))
                {{ $message }}
            @endif
        </div>

        <br>
        {!! Form::close() !!}
        @if(!is_empty(Auth::user()->password))
            <div class="form-group">
                <h4>{{ trans("front.changePassword") }}</h4>
            </div>
            <hr>
            {!! Form::open(["url" => URL::action("SettingsController@password"), "class" => "settingsFormPassword", "role" => "form"]) !!}
            <div class="form-group">
                <input class="form-control" type="password" name="current_password" id="current_password" placeholder="{{ trans('front.currentPassword') }}">
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="new_password" id="newPassword" placeholder="{{ trans('front.newPassword') }}">
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="password_confirmation" id="confirmPassword" placeholder="{{ trans('front.confirmPassword') }}">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success btn-sm" value={{ trans("front.change") }}>
            </div>
            @if($errors->any() || isset($alert))
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-warning">{{ $error }}</div>
                    @endforeach
                @endif

                @if(isset($alert))
                    <div class="alert alert-warning">{{ $alert }}</div>
                @endif
            @endif
            {!! Form::close() !!}
        @else
            <div class="form-group">
                <h4>{{ trans("front.createPassword") }}</h4>
            </div>
            <hr><br>
            {!! Form::open(["url" => URL::action("SettingsController@passwordCreate"), "class" => "settingsFormPassword", "role" => "form"]) !!}
            <div class="form-group">
                <input class="form-control" type="password" name="new_password" id="newPassword" placeholder="{{ trans('front.newPassword') }}">
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="password_confirmation" id="confirmPassword" placeholder="{{ trans('front.confirmPassword') }}">
            </div>
            <input class="btn btn-success btn-sm" type="submit" value={{ trans("front.save") }}><br>
            @if($errors->any() || (isset($alert)) and !is_empty($alert))
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-warning">{{ $error }}</div>
                    @endforeach
                @endif

                @if(isset($alert))
                    <div class="alert alert-warning">{{ $alert }}</div>
                @endif
            @endif
            {!! Form::close() !!}
        @endif

        <br><br>
        <div class="form-group">
            <button data-toggle="modal" data-target="#myModal" class="btn-link">{{ trans("front.removeAccount") }}</button>
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{ trans("front.removeAccount") }}</h4>
                    </div>
                    <div class="modal-body">
                        <p>{{ trans("front.warningMessage") }}</p>
                        {!! Form::open(["url" => URL::action("UsersController@destroy", $user->id), "method" => "delete"]) !!}

                    </div>
                    <div class="modal-footer">

                        {!! Form::submit(trans("front.confirm"), ["class" => "btn btn-success"]) !!}
                        <button class="btn btn-default" data-dismiss="modal">{{ trans("front.cancel") }}</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection