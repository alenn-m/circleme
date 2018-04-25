@if(!Request::is("*planner") and !Request::is("*planner*") and count($categories) > 0)
    <nav class="navbar navbar-default navbar-categories">
        <div class="container">

            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <li @if(!isset($cat)) class="active" @endif><a href="{{ URL::action('HomeController@home') }}">{{ trans("front.all") }}</a></li>
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <li @if(isset($cat) and $category->id == $cat) class="active" @endif><a href="{{ URL::action('HomeController@category', $category->id) }}">{{ $category->name }}</a></li>
                            @endforeach
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </nav>

@else

    <br/>

@endif