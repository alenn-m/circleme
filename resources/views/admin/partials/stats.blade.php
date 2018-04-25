<br/>

<style>
    .panel-body{
        padding: 0;
    }

    .table{
        margin-bottom: 0;
    }
</style>

<div class="row">

    <div class="col-md-6 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">{{ trans("admin.latestUsers") }}</h3>
            </div>
            <div class="panel-body">
                @if(isset($users) and count($users) > 0)

                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th>{{ trans("admin.username") }}</th>
                            <th>{{ trans("admin.email") }}</th>
                        </tr>

                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        @endforeach

                    </table>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">{{ trans("admin.latestEvents") }}</h3>
            </div>
            <div class="panel-body">
                @if(isset($events) and count($events) > 0)

                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th>{{ trans("admin.title") }}</th>
                            <th>{{ trans("admin.date") }}</th>
                        </tr>

                        @foreach($events as $event)
                            <tr>
                                <td>{{ $event->title }}</td>
                                <td>{{ localDate($event->date) }}</td>
                            </tr>
                        @endforeach

                    </table>
                @endif
            </div>
        </div>
    </div>

</div>

<br/>

<div class="row">

    <div class="col-md-6 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">{{ trans("admin.latestPosts") }}</h3>
            </div>
            <div class="panel-body">
                @if(isset($posts) and count($posts) > 0)

                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th>{{ trans("admin.body") }}</th>
                            <th>{{ trans("admin.user") }}</th>
                        </tr>

                        @foreach($posts as $post)
                            <tr>
                                <td>{{ truncString($post->body, 30) }}</td>
                                <td>{{ $post->user->username }}</td>
                            </tr>
                        @endforeach

                    </table>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">{{ trans("admin.latestComments") }}</h3>
            </div>
            <div class="panel-body">
                @if(isset($comments) and count($comments) > 0)

                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th>{{ trans("admin.comment") }}</th>
                            <th>{{ trans("admin.user") }}</th>
                        </tr>

                        @foreach($comments as $comment)
                            <tr>
                                <td>{{ truncString($comment->comment, 30) }}</td>
                                <td>{{ $comment->user->username }}</td>
                            </tr>
                        @endforeach

                    </table>
                @endif
            </div>
        </div>
    </div>

</div>