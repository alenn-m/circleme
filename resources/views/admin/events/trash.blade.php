@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h2 class="top-heading">{{ trans("admin.deletedEvents") }}</h2>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-12">
            <a href="{{ URL::action('Admin\EventsController@index') }}" class="btn btn-primary btn-sm">{{ trans("admin.goBack") }}</a>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-hover table-condensed">
                <tr>
                    <th>{{ trans("admin.title") }}</th>
                    <th>{{ trans("admin.user") }}</th>
                    <th>{{ trans("admin.date") }}</th>
                    <th>{{ trans("admin.type") }}</th>
                    <th></th>
                </tr>

                @if(count($events) > 0)
                    @foreach($events as $event)
                        <tr>
                            <td><a target="_blank" href="{{ URL::action('EventsController@show', $event->id) }}">{{ $event->title }}</a></td>
                            <td>{{ $event->user->getFullname() }}</td>
                            <td>{{ localDate($event->date) }}</td>
                            <td>{{ trans("admin." . $event->type) }}</td>
                            <td>
                                {!! Form::open(["url" => URL::action("Admin\EventsController@destroy", $event->id), "method" => "delete"]) !!}
                                {!! Form::hidden('force', true) !!}
                                <a href="{{ URL::action('Admin\EventsController@restore', $event->id) }}" class="btn btn-warning btn-sm  ">{{ trans("admin.restore") }}</a>
                                {!! Form::submit(trans("admin.delete"), ["class" => "btn btn-danger btn-sm"]) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>

            {!! $events->render() !!}
        </div>
    </div>

@endsection