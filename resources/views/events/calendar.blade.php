@extends("layouts.wide")

@section("content")

    {!! Minify::stylesheet("/css/daterangepicker.css") !!}
    {!! Minify::javascript(["/js/moment.min.js", "/js/jquery.daterangepicker.js"]) !!}

    <div class="row">
        <div class="col-md-9 col-xs-12">

            @if(!Request::is("*past") and !Request::is("*category*"))
                <div class="row">
                    <div class="col-xs-12">
                        @if(!isset($time))
                            <span data-url="{{ URL::action('EventsController@timeFilter') }}" class="label label-default time-filter label-filter">{{ trans("front.anyTime") }}</span>
                        @else
                            <span data-url="{{ URL::action('EventsController@timeFilter') }}" class="label label-primary time-filter label-filter">{{ $time }}
                                <a href="{{ URL::action('EventsController@upcoming') }}" class="time-filter-cancel"><i class="fa fa-times"></i></a>
                            </span>
                        @endif
                    </div>
                </div>
                <br/>
            @endif

            <div class="row">
                <div class="col-xs-12 eventLoader">
                    @include("layouts.partials.loadEvents")
                </div>
            </div>


        </div>

        <div class="col-md-3 col-xs-12">
            <div class="list-group">
                <a class="list-group-item @if(Request::is('*planner')) active @endif" href="{{ URL::action('EventsController@upcoming') }}">{{ trans("front.upcomingEvents") }}</a>
                <a class="list-group-item @if(Request::is('*past')) active @endif"  href="{{ URL::action('EventsController@past') }}">{{ trans("front.pastEvents") }}</a>
            </div>

            @if(isset($categories) && count($categories) > 0)
                <h4><small>{{ ucfirst(trans("categories")) }}</small></h4>

                <div class="list-group">
                    @foreach($categories as $category)
                        <a class="list-group-item @if(Request::is('*category/' . strtolower($category->name))) active @endif" href="{{ URL::action('EventsController@byCategory', strtolower($category->name)) }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @if(!Request::is("*past") and !Request::is("*category*"))
    <script>
        $(document).ready(function(){
            $.dateRangePickerLanguages['custom'] = {
                'days': Lang.get("front.days"),
                'week-1' : Lang.get("front.mon"),
                'week-2' : Lang.get("front.tue"),
                'week-3' : Lang.get("front.wed"),
                'week-4' : Lang.get("front.thu"),
                'week-5' : Lang.get("front.fri"),
                'week-6' : Lang.get("front.sat"),
                'week-7' : Lang.get("front.sun"),
                'month-name': [Lang.get("front.january"),Lang.get("front.february"),Lang.get("front.march"),Lang.get("front.april"),Lang.get("front.may"),Lang.get("front.june"),Lang.get("front.july"),Lang.get("front.august"),Lang.get("front.september"),Lang.get("front.october"),Lang.get("front.november"),Lang.get("front.december")]
            };

            $(".time-filter").dateRangePicker({
                showTopbar: false,
                autoClose: true,
                showShortcuts: false,
                language: "custom"
            }).bind('datepicker-change',function(event,obj){

                var url = $(".time-filter").attr("data-url");
                window.location.href=url + "?from=" + moment(obj.date1).unix() + "&to=" + moment(obj.date2).unix();

	        });

	        $(".time-filter-cancel").click(function(e){
	            e.stopPropagation();
	        });

        });
    </script>
    @endif

@endsection