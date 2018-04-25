@extends("circles.main")

@section("subcontent")

    @include("circles.partials.top")

    <div class="row">
        <div class="col-xs-12 list-profiles">
        @if(isset($users) && count($users) > 0)
            @foreach($users as $user)
                <div class="single-profile" data-user_id = "{{ $user->id }}">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="avatar-big">
                                {!! HTML::image("/img/nouser.png", "User", ["width" => "100%"]) !!}
                            </div>
                        </div>

                        <div class="col-xs-7">
                            <label style="margin:0;">{{ $user->getFullname() }}</label>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $(".single-profile").draggable({
                revert: "invalid",
                containment: "body",
                helper: "clone",
                start: function(){
                    $(this).css("background-color", "#3498db").css("color", "white");
                },
                stop: function(){
                    $(this).css("background-color", "white").css("color", "#666");
                }
            });

            $(".circle").droppable({
                accept: ".single-profile",
                drop: function(event, ui){
                    $(ui.draggable).fadeOut(200);

                    var circle = $(this).attr("data-circle_id");
                    var user = $(ui.draggable).attr("data-user_id");
                    var url = $(this).attr("data-add_url");

                    var t = $(this);

                    $.post(url, {"user": user, "circle": circle}, function(data){
                        if(data.response == "ok"){
                            t.find("label").html(data.count);
                        }
                    });

                    $(this).popover("show");

                    $(this).removeClass("active");
                },
                over: function(){
                    $(this).addClass("active");
                },
                out: function(){
                    $(this).removeClass("active");
                }
            });
        });
    </script>

@endsection