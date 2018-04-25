@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h2 class="top-heading">{{ trans("admin.comments") }}</h2>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-12">
            @if(count(App\Http\Models\Comment::onlyTrashed()->get()) > 0)
                <a href="{{ URL::action('Admin\CommentsController@trash') }}" class="btn btn-danger btn-sm pull-right"><i class="fa fa-trash-o"></i> {{ trans("admin.trash") }}</a>
            @endif
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-hover table-condensed">
                <tr>
                    <th>{{ trans("admin.comment") }}</th>
                    <th>{{ trans("admin.user") }}</th>
                    <th>{{ trans("admin.post") }}</th>
                    <th></th>
                </tr>

                @if(count($comments) > 0)
                    @foreach($comments as $comment)
                        <tr>
                            <td>{{ truncString($comment->comment, 50) }}</td>
                            <td><a target="_blank" href="{{ URL::action('UsersController@show', $comment->user_id) }}">{{ $comment->user->getFullname() }}</a></td>
                            <td><a target="_blank" href="{{ URL::action('EventsController@show', $comment->post->event->id) }}#{{ $comment->post->id }}">{{ $comment->post->body }}</a></td>
                            <td>
                                {!! Form::open(["url" => URL::action("Admin\CommentsController@destroy", $comment->id), "method" => "delete"]) !!}
                                <a href="{{ URL::action('Admin\CommentsController@edit', $comment->id) }}" class="btn btn-warning btn-sm  ">{{ trans("admin.edit") }}</a>
                                {!! Form::submit(trans("admin.delete"), ["class" => "btn btn-danger btn-sm"]) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>

            {!! $comments->render() !!}
        </div>
    </div>

@endsection