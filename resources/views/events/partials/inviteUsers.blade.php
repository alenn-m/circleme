<div class="row">
    <div class="col-md-2 col-xs-12 searchUrl" data-url="{{ URL::action('EventsController@search') }}">

        <span data-url="{{ URL::action('EventsController@selectedUsers') }}" class="label label-primary selected-number"><span></span> {{ trans("front.selected") }}</span>

        <h5>{{ trans("front.circles") }}</h5>

        <div class="singleCircle active" data-id="all" style="margin-left: 10px;">
            <span>{{ trans("front.all") }}</span>
        </div>

        @if(isset($circles))
            @foreach($circles as $circle)
                <div class="singleCircle singleCircleLarge" data-id="{{ $circle->id }}" style="margin-left: 10px;">
                    <i class="fa fa-circle-o"></i>

                    <span>{{ $circle->name }}</span>
                </div>
            @endforeach
        @endif
    </div>

    <div class="col-md-10 col-xs-12 inviteUsersList">
        <div class="row">
            <div class="col-xs-12" data-url="{{ URL::action('EventsController@search') }}">
                {!! Form::text("search", null, ["placeholder" => trans("front.findPeople"), "class" => "form-control event_search_input", "style" => "background-color: white;padding:0 10px;"]) !!}
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
    </div>
</div>
