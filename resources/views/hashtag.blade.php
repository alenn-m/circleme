@extends("layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h2 style="margin:0;"><small>#{{ $hashtag }}</small></h2>
            <hr style="border-color:lightgray;background-color: #d3d3d3;margin-top:0;"/>
        </div>
    </div>

    <div class="loadPosts">
        <div id="grid" data-columns class="col-xs-12" style="padding:0;">
            @include("events.partials.hashPosts")
        </div>
    </div>

    <style>
        .loadPosts .singlePost{
            margin: 0px;
        }
    </style>

    <script>

        $("#grid").infinitescroll({
            navSelector     : ".pagination",
            nextSelector    : ".pagination a:last",
            itemSelector    : ".singlePost",
            debug           : false,
            dataType        : 'html',
            loadingText  	: "{{ trans('front.loading') }}...",
            donetext		: "",
            path: function(index) {
                if(window.location.href.indexOf("?search=") > -1){
                    return window.location.href + "&page=" + index;
                }else{
                    return "?page=" + index;
                }

            },
            loading : {
                msgText: "",
                finishedMsg: "",
            }
        }, function(newElements, data, url){
            console.log(newElements);
            var grid = document.querySelector('#grid');

            salvattore.appendElements(grid, newElements);
        });
    </script>

@endsection