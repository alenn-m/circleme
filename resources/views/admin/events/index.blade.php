@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h2 class="top-heading">{{ trans("admin.events") }}</h2>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-12">
            <a target="_blank" href="{{ URL::action('EventsController@create') }}" class="btn btn-primary btn-sm">{{ trans("admin.newEvent") }}</a>
            @if(count(App\Http\Models\Event::onlyTrashed()->get()) > 0)
                <a href="{{ URL::action('Admin\EventsController@trash') }}" class="btn btn-danger btn-sm pull-right"><i class="fa fa-trash-o"></i> {{ trans("admin.trash") }}</a>
            @endif
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
                                <a target="_blank" href="{{ URL::action('EventsController@edit', $event->id) }}" class="btn btn-warning btn-sm  ">{{ trans("admin.edit") }}</a>
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