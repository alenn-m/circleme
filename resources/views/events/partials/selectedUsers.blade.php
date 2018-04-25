<div class="row">
    <div class="col-xs-12 searchUrl" data-url="{{ URL::action('EventsController@search') }}">
        @if(isset($circle_id))
            <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn btn-primary select-circle-btn">{{ trans("front.selectAll") }}</button>
                </span>
                {!! Form::text("search", null, ["placeholder" => trans("front.findPeople"), "class" => "form-control event_search_input", "style" => "background-color: white;padding:0 10px;"]) !!}
            </div>

        @else

            {!! Form::text("search", null, ["placeholder" => trans("front.findPeople"), "class" => "form-control event_search_input", "style" => "background-color: white;padding:0 10px;"]) !!}

        @endif


    </div>
</div>

<div class="usersGrid">
    <div class="row">
        @if(isset($users))
            @foreach($users as $user)
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="singleInviteUser" data-id="{{ $user->id }}">
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
                </div>
            @endforeach
        @else
            <h4>{{ trans("front.noUsers") }}</h4>
        @endif
    </div>
</div>