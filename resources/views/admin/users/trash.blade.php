@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h2 class="top-heading">{{ trans("admin.deletedUsers") }}</h2>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-12">
            <a href="{{ URL::action('Admin\UsersController@index') }}" class="btn btn-primary btn-sm">{{ trans("admin.goBack") }}</a>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-hover table-condensed">
                <tr>
                    <th>{{ trans("admin.username") }}</th>
                    <th>{{ trans("admin.email") }}</th>
                    <th>{{ trans("admin.active") }}</th>
                    <th>{{ trans("admin.banned") }}</th>
                    <th>{{ trans("admin.role") }}</th>
                    <th></th>
                </tr>

                @if(count($users) > 0)
                    @foreach($users as $user)
                        <tr>
                            <td><a target="_blank" href="{{ URL::action('UsersController@show', $user->username) }}">{{ $user->username }}</a></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->active ? trans("admin.yes") : trans("admin.no") }}</td>
                            <td>{{ $user->banned ? trans("admin.yes") : trans("admin.no") }}</td>
                            <td>{{ trans("admin." . $user->role) }}</td>
                            <td>
                                {!! Form::open(["url" => URL::action("Admin\UsersController@destroy", $user->id), "method" => "delete"]) !!}
                                    {!! Form::hidden('force', true) !!}
                                    <a href="{{ URL::action('Admin\UsersController@restore', $user->id) }}" class="btn btn-warning btn-sm  ">{{ trans("admin.restore") }}</a>
                                    {!! Form::submit(trans("admin.delete"), ["class" => "btn btn-danger btn-sm"]) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>

            {!! $users->render() !!}
        </div>
    </div>

@endsection