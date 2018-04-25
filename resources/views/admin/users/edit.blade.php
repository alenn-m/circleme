@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h3>{{ trans("admin.editUser") }}</h3>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            {!! Form::open(["url" => URL::action("Admin\UsersController@update", $user->id), "files" => true, "method" => "PUT"]) !!}
            <div class="form-group">
                {!! Form::text("username", $user->username, ["class" => "form-control", "placeholder" => trans("admin.username")]) !!}
            </div>

            <div class="form-group">
                {!! Form::text("email", $user->email, ["class" => "form-control", "placeholder" => trans("admin.email")]) !!}
            </div>

            <div class="form-group">
                {!! Form::text("password", null, ["class" => "form-control", "placeholder" => trans("admin.password")]) !!}
            </div>

            <div class="form-group">
                {!! Form::text("fullname", $user->fullname, ["class" => "form-control", "placeholder" => trans("admin.fullname")]) !!}
            </div>

            <div class="form-group">
                {!! Form::textarea("about", $user->about, ["class" => "form-control", "placeholder" => trans("admin.about"), "rows" => 5]) !!}
            </div>

            <div class="form-group">
                <input type="checkbox" name="active" @if($user->active) checked @endif/>
                <label for="">{{ trans("admin.active") }}</label>
            </div>

            <div class="form-group">
                <label for="">{{ trans("admin.avatar") }}</label><br/>
                <input type="file" name="avatar"/>
            </div>

            <div class="form-group">
                <label for="">{{ trans("admin.background") }}</label>
                <input type="file" name="background"/>
            </div>

            <div class="form-group">
                <label for="">{{ trans("admin.role") }}</label><br/>
                <select name="role" class="form-control">
                    <option @if($user->role == "user") selected @endif value="user">{{ trans("admin.user") }}</option>
                    <option @if($user->role == "admin") selected @endif value="admin">{{ trans("admin.admin") }}</option>
                </select>
            </div>

            {!! Form::submit(trans("admin.update"), ["class" => "btn btn-primary"]) !!}
            <a href="{{ URL::action('Admin\UsersController@index') }}" class="btn btn-default">{{ trans("admin.cancel") }}</a>
            {!! Form::close() !!}

            @if($errors->any())
                <div class="alert alert-warning" style="text-align: center">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br/>
                    @endforeach
                </div>
            @endif

            <br/>
        </div>
    </div>

@endsection