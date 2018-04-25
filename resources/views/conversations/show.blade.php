@extends("conversations.index")

@section("conversation")

    <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans("front.areYouSure") }}?</h4>
                </div>
                <div class="modal-footer">
                    {!! Form::open(["url" => URL::action('ConversationsController@destroy', $conversation->id), "method" => "DELETE", "class" => "deleteConversationForm"]) !!}
                    {!! Form::submit(trans("front.yes"), ["class" => "btn btn-primary"]) !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans("front.no") }}</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="white-box" style="margin-top: 0;">

        <div class="row">
            <div class="col-xs-12">
                <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#confirmDelete">
                    {{ trans("front.deleteConversation") }}
                </button>

                {!! $messages->render() !!}

                <button class="loadMore btn-link">{{ trans("front.loadMore") }}</button>
            </div>
        </div>

        <br/>

        <div class="row">
            <div class="col-xs-12 grid">
                @foreach($messages->reverse() as $message)
                    <div class="row singleMessage" style="margin-bottom:10px;">
                        @if($message->user)
                            <div class="col-xs-1" style="padding-right:0;text-align:center;">
                                {!! HTML::image($message->user()->first()->getAvatar(), "User image", ["id" => "messageUserAvatar", "width" => "32", "height" => "32"]) !!}
                            </div>
                            <div class="col-xs-11">
                                <p id="messageBody" >
                                    <a href="{{ URL::action('UsersController@show', $message->user()->first()->username) }}">
                                        {{ $message->user()->first()->username }}
                                    </a>
                                    <span style="font-family:'Lato';font-size:70%; color: gray;font-style:italic;">
                                        {{ localDate($message->created_at) }} {{ trans("front.at") }} {{ nice_date($message->created_at) }}
                                    </span>

                                    <br>

                                    <span style="line-height: 20px;">{{ $message->message }}</span>
                                </p>
                            </div>
                        @else
                            {!! HTML::image("/img/nouser.png", "User image", ["id" => "messageUserAvatar"]) !!}
                            <p id="messageBody" >{{ trans("front.unknownUser") }} <span style="font-family:'Lato';font-size:70%; color: gray;font-style:italic;">{{ localDate($message->created_at) }}</span><br><span style="line-height: 20px;">{{ $message->message }}</span></p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <hr/>

        <div class="row">
            <div class="col-xs-12">
                {!! Form::open(["action" => "ConversationsController@storeMessage", "class" => "replyDiv", "role" => "form"]) !!}
                <textarea name="message" placeholder="{{ trans('front.message') }}..." class="form-control"></textarea>

                <input name="conversation" type="text" style='display:none' value="{{ $conversation->id }}">
                <button type="submit" class="btn btn-success btn-md" style="margin:10px 0;">{{ trans("front.reply") }}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script>

        $(window).unbind('.infscr');
        $(".grid").infinitescroll({
            navSelector     : ".pagination",
            nextSelector    : ".pagination a:last",
            itemSelector    : ".singleMessage",
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
            }, errorCallback: function(selector, msg){
		    	if(selector == "done"){
		    		$(".loadMore").fadeOut(200);
		    	}
		    }
        }, function(newElements, data, url){
            $(".grid").prepend(newElements);

            $(".loadMore").text(Lang.get("front.loadMore")).attr("disabled", false);
        });

        $(window).unbind('.infscr');

        $(".loadMore").click(function(){
            $(this).text(Lang.get("front.loading") + "...");
            $(this).attr("disabled", true);
            $(".grid").infinitescroll('retrieve');
        });
    </script>


@endsection