@extends("admin.layouts.main")

@section("content")

    {!! Minify::javascript(["/js/rafael.js", "/js/morris.min.js"]) !!}
    {!! Minify::stylesheet("/css/morris.css") !!}

    <br/>

    <div class="row upperRow">
        <div class="col-md-3 col-xs-6" style="text-align: center;border-right:2px solid lightgray;">
            <div class="row">
                <div class="col-xs-12">
                    <small>
                        <span class="text-muted">
                            <i class="fa fa-users"></i>
                            <span>{{ trans("admin.users") }}</span>
                        </span>
                    </small>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h4><span class="text-muted">{{ trans("admin.total") }}:</span> {{ $users["total"] }}</h4>
                    <h4><span class="text-muted">{{ trans("admin.banned") }}:</span> {{ $users["banned"] }}</h4>
                    <h4><span class="text-muted">{{ trans("admin.innactive") }}:</span> {{ $users["innactive"] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xs-6" style="text-align: center;border-right:2px solid lightgray;">
            <div class="row">
                <div class="col-xs-12">
                    <small>
                        <span class="text-muted">
                            <i class="fa fa-fw fa-calendar"></i>
                            <span>{{ trans("admin.events") }}</span>
                        </span>
                    </small>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h4><span class="text-muted">{{ trans("admin.total") }}:</span> {{ $events["total"] }}</h4>
                    <h4><span class="text-muted">{{ trans("admin.public") }}:</span> {{ $events["public"] }}</h4>
                    <h4><span class="text-muted">{{ trans("admin.private") }}:</span> {{ $events["private"] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xs-6" style="text-align: center;border-right:2px solid lightgray;">
            <div class="row">
                <div class="col-xs-12">
                    <small>
                        <span class="text-muted">
                            <i class="fa fa-file-text"></i>
                            <span>{{ trans("admin.posts") }}</span>
                        </span>
                    </small>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h4><span class="text-muted">{{ trans("admin.total") }}:</span> {{ $posts }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xs-6" style="text-align: center;border-right:2px solid lightgray;">
            <div class="row">
                <div class="col-xs-12">
                    <small>
                        <span class="text-muted">
                            <i class="fa fa-comment"></i>
                            <span>{{ trans("admin.comments") }}</span>
                        </span>
                    </small>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h4><span class="text-muted">{{ trans("admin.total") }}:</span> {{ $comments }}</h4>
                </div>
            </div>
        </div>

    </div>

    <hr/>

    <div data-url="{{ URL::action('Admin\AdminController@fetchData') }}" id="chart" style="height: 250px;"></div>

    <div class="loadStats" data-url="{{ URL::action('Admin\AdminController@getStats') }}">

    </div>

    <script>

        $.get($("#chart").attr("data-url"), null, function(data){

            Morris.Area({
              element: 'chart',
              data: data.data,
              xkey: 'date',
              ykeys: ['users', 'events', 'posts', 'comments'],
              labels: ['Users', 'Events', 'Posts', 'Comments'],
              behaveLikeLine: true,
              parseTime: false,
              resize: true
            });
        }, "json");

        $.get($(".loadStats").attr("data-url"), null, function(data){
            $(".loadStats").html(data.view);
        }, "json");


    </script>

@endsection