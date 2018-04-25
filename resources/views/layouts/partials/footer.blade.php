<br/>

<footer>
    <ul>
        <li><a href="{{ URL::action("ContactController@getContact") }}">{{ trans("front.contact") }}</a></li>

        @if(isset($pages) && count($pages) > 0)
            @foreach($pages as $page)
                <li><a href="{{ URL::action("PagesController@show", $page->id) }}">{{ $page->short_title }}</a></li>
            @endforeach
        @endif
    </ul>

    <ul style="margin-top: 0">
        <li><span class="text-muted">{{ Config::get("settings.title") }} @ {{ date("Y") }}</span></li>
    </ul>
</footer>

<br/>