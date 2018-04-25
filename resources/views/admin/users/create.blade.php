@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h3>{{ trans("admin.createUser") }}</h3>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            {!! Form::open(["url" => URL::action("Admin\UsersController@store"), "files" => true]) !!}
                <div class="form-group">
                    {!! Form::text("username", null, ["class" => "form-control", "placeholder" => trans("admin.username")]) !!}
                </div>

                <div class="form-group">
                    {!! Form::text("email", null, ["class" => "form-control", "placeholder" => trans("admin.email")]) !!}
                </div>

                <div class="form-group">
                    {!! Form::text("password", null, ["class" => "form-control", "placeholder" => trans("admin.password")]) !!}
                </div>

                <div class="form-group">
                    {!! Form::text("fullname", null, ["class" => "form-control", "placeholder" => trans("admin.fullname")]) !!}
                </div>

                <div class="form-group">
                    {!! Form::textarea("about", null, ["class" => "form-control", "placeholder" => trans("admin.about"), "rows" => 5]) !!}
                </div>

                <div class="form-group">
                    <input type="checkbox" name="active" checked/>
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
                        <option value="user">{{ trans("admin.user") }}</option>
                        <option value="admin">{{ trans("admin.admin") }}</option>
                    </select>
                </div>

                {!! Form::submit(trans("admin.create"), ["class" => "btn btn-primary"]) !!}
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