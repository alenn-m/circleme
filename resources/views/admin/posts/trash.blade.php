@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h2 class="top-heading">{{ trans("admin.deletedPosts") }}</h2>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-12">
            <a href="{{ URL::action('Admin\PostsController@index') }}" class="btn btn-primary btn-sm">{{ trans("admin.goBack") }}</a>
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-hover table-condensed">
                <tr>
                    <th>{{ trans("admin.user") }}</th>
                    <th>{{ trans("admin.body") }}</th>
                    <th>{{ trans("admin.event") }}</th>
                    <th>{{ trans("admin.type") }}</th>
                    <th></th>
                </tr>

                @if(count($posts) > 0)
                    @foreach($posts as $post)
                        <tr>
                            <td><a target="_blank" href="{{ URL::action('UsersController@show', $post->user->username) }}">{{ $post->user->username }}</a></td>
                            <td><a target="_blank" href="{{ URL::action('EventsController@show', $post->event->id) }}#{{ $post->id }}">{{ $post->body ? truncString($post->body, 50) : trans("admin.emptyBody") }}</a></td>
                            <td>{{ truncString($post->event->title, 50) }}</td>
                            <td>{{ $post->image ? trans("admin.image") : trans("admin.text") }}</td>
                            <td>
                                {!! Form::open(["url" => URL::action("Admin\PostsController@destroy", $post->id), "method" => "delete"]) !!}
                                {!! Form::hidden('force', true) !!}
                                <a href="{{ URL::action('Admin\PostsController@restore', $post->id) }}" class="btn btn-warning btn-sm  ">{{ trans("admin.restore") }}</a>
                                {!! Form::submit(trans("admin.delete"), ["class" => "btn btn-danger btn-sm"]) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>

            {!! $posts->render() !!}
        </div>
    </div>

@endsection