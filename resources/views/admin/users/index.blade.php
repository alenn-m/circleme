@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h2 class="top-heading">{{ trans("admin.users") }}</h2>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-12">
            <a href="{{ URL::action('Admin\UsersController@create') }}" class="btn btn-primary btn-sm">{{ trans("admin.newUser") }}</a>
            @if(count(App\Http\Models\User::onlyTrashed()->get()) > 0)
                <a href="{{ URL::action('Admin\UsersController@trash') }}" class="btn btn-danger btn-sm pull-right"><i class="fa fa-trash-o"></i> {{ trans("admin.trash") }}</a>
            @endif
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
                                    <a href="{{ URL::action('Admin\UsersController@edit', $user->id) }}" class="btn btn-warning btn-sm  ">{{ trans("admin.edit") }}</a>
                                    {!! Form::submit(trans("admin.delete"), ["class" => "btn btn-danger btn-sm"]) !!}
                                    @if($user->banned)
                                        <a href="{{ URL::action('Admin\UsersController@unban', $user->id) }}" class="btn btn-default btn-sm">{{ trans("admin.unban") }}</a>
                                    @else
                                        <a href="{{ URL::action('Admin\UsersController@ban', $user->id) }}" class="btn btn-default btn-sm">{{ trans("admin.ban") }}</a>
                                    @endif
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