@extends("layouts.main")

@section("content")

    {!! HTML::script("js/jquery.fileupload.js") !!}
    {!! HTML::script("/js/nanobar.min.js") !!}
    {!! HTML::script("/datepicker/js/bootstrap-datepicker.min.js") !!}
    {!! HTML::style("css/jquery.fileupload.css") !!}

    <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>

    <div class="white-box">

        @if($errors->any())
            <div class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <label><strong>{{ $error }}</strong></label><br/>
                @endforeach
            </div>
        @endif

        {!! Form::open(["url" => URL::action("EventsController@update", $event->id), "method" => "PUT", "class" => "eventsForm", "files" => true]) !!}
        <div class="form-group">
            <div style="height:350px;overflow: hidden;position:relative" class="cover-wrap">

                <div class="row dragMe-div">
                    <div class="col-xs-12">
                    <span>
                        {{ trans("front.dragToReposition") }}
                    </span>
                    </div>
                </div>

                <div class="image-error">
                    <div class="alert alert-danger">
                        {{ trans("front.minimumImageDimensions") }} (600x350 px)
                    </div>
                </div>

                {!! HTML::image($event->getImage(), "Cover image",  ["width" => "100%", "class" => "coverImage", "style" => "position:absolute;top:".$event->cover_position . "px"]) !!}

                <span class="fileinput-button btn btn-warning btn-sm" style="position:absolute;bottom:0;left:0;">
                <label>{{ trans("front.uploadImage") }}</label>
                <input id="fileupload" type="file" name="file">
            </span>
            </div>

            {!! Form::hidden("image", $event->image, ["class" => "imgPathHolder"]) !!}
            {!! Form::hidden("cover_position", $event->cover_position, ["class" => "cover-position"]) !!}
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-xs-8">
                    {!! Form::text("title", $event->title, ["placeholder" => trans("front.title"), "class" => "form-control"]) !!}
                </div>

                <div class="col-xs-4" style="text-align: center;">
                    <select multiple name="eventoptions" id="eventoption">
                        <option value="guestCanInvite" @if($event->guestCanInvite) selected @endif>{{ trans("front.guestCanInvite") }}</option>
                        <option value="guestCanPublish" @if($event->guestCanPublish) selected @endif>{{ trans("front.guestCanPublish") }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::textarea("description", $event->description, ["placeholder" => trans("front.description"), "class" => "form-control", "rows" => "2", "data-autoresize"]) !!}
        </div>

        {!! Form::hidden("city", null, ["class" => "cityHolder"]) !!}
        {!! Form::hidden("country", null, ["class" => "countryHolder"]) !!}


        <div class="form-group">
            <input name="address" type="text" class="form-control" id="us3-address"/>
        </div>


        <div id="us3" class="event-map" style="width: 100%; height: 200px;display:none;"></div>

        <div class="m-t-small" style="display:none">
            <input name="lat" type="text" class="form-control" style="width: 110px" id="us3-lat"/>
            <input name="lng" type="text" class="form-control" style="width: 110px" id="us3-lon"/>
        </div>

        <script>
        $(document).ready(function(){
            function updateControls(addressComponents) {
                $('.cityHolder').val(addressComponents.city);
                $('.countryHolder').val(addressComponents.country);
            }

            $('#us3').locationpicker({
                location: {latitude: '{{ $event->lat }}', longitude: '{{ $event->lng }}'},
                radius: 0,
                inputBinding: {
                    latitudeInput: $('#us3-lat'),
                    longitudeInput: $('#us3-lon'),
                    locationNameInput: $('#us3-address')
                },
                enableAutocomplete: true,
                onchanged: function (currentLocation, radius, isMarkerDropped) {
                    var addressComponents = $(this).locationpicker('map').location.addressComponents;
                    updateControls(addressComponents);
                },
                oninitialized: function(component) {
                    var addressComponents = $(component).locationpicker('map').location.addressComponents;
                    updateControls(addressComponents);
                }
            });
        });
    </script>

        <div class="form-group">
            <div class="row">
                <div class="col-xs-7">
                    {!! Form::text("date", $event->date, ["placeholder" => trans("front.date"), "class" => "form-control date"]) !!}
                </div>

                <div class="col-xs-2">
                    <select name="time" class="form-control">
                        <option value="0">{{ trans("front.time") }}</option>
                        @for($i = 0; $i<=9;$i++)
                            <option @if($event->time == "0".$i."00") selected @endif value="0{{$i}}00">0{{$i}}:00</option>
                            <option @if($event->time == "0".$i."30") selected @endif value="0{{$i}}30">0{{$i}}:30</option>
                        @endfor
                        @for($i=10;$i<=23;$i++)
                            <option @if($event->time == $i."00") selected @endif value="{{$i}}00">{{$i}}:00</option>
                            <option @if($event->time == $i."30") selected @endif value="{{$i}}30">{{$i}}:30</option>
                        @endfor
                    </select>
                </div>
            </div>

        </div>

        <div class="form-group">
            <select name="categories[]" id="categorySelector" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <h4>{{ trans("front.eventType") }}</h4>
            <div class="col-xs-12">
                <input type="radio" name="type" value="public" @if($event->type == "public") checked @endif />
                <span>{{ trans("front.public") }}</span>

                <input type="radio" name="type" value="private" @if($event->type == "private") checked @endif/>
                <span>{{ trans("front.private") }}</span>
            </div>
        </div>

        <br/><br/>

        {!! Form::submit(trans("front.update"), ["class" => "btn btn-success"]) !!}
            <a href="{{ URL::action('EventsController@show', $event->id) }}" class="btn btn-default">{{ trans("front.cancel") }}</a>

        {!! Form::close() !!}

        <div class="pull-right">
            {!! Form::open(["url" => URL::action("EventsController@destroy", $event->id), "method" => "delete"]) !!}
                {!! Form::submit(trans("front.delete"), ["class" => "btn btn-danger btn-sm"]) !!}
            {!! Form::close() !!}
        </div>
    </div>

    <script>
    $(document).ready(function(){

        $(".date").datepicker({
            "setDate" : new Date(),
            "format" : "yyyy-mm-dd"
        });

        $('#eventoption').multiselect({
            buttonText : function(options, select){
                return "{{ trans('front.eventOptions') }}";
            }
        });

        $('#categorySelector').multiselect({
            buttonText : function(options, select){

                if (options.length === 0) {
                    return "{{ trans('front.uncategorized') }}";
                }
                else {
                     var labels = [];
                     options.each(function() {
                         if ($(this).attr('label') !== undefined) {
                             labels.push($(this).attr('label'));
                         }
                         else {
                             labels.push($(this).html());
                         }
                     });
                     return labels.join(', ') + '';
                }
            }

        });

        var options = {
            bg: '#e74c3c',
            id: 'mynano'
        };

        var nanobar = new Nanobar( options );

        var url = "{{ URL::action('EventsController@uploadImage') }}";

        var checkSize = function(width, height){
			if(width < 600 || height < 350){
				$(".image-error").fadeIn(200);
			}else{
				$(".image-error").fadeOut(100);
			}
		}

        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {"_method": "POST"},
            always: function(e, data){

                if(data.result.size == "ok"){
                    $(".imgPathHolder").val(data.result.message);
                    $(".coverImage").attr("src", "/uploads/"+data.result.message);
                    $(".image-error").fadeOut(200);
                }else if(data.result.size == "error"){
                    $(".image-error").fadeIn(200);
                }

            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                nanobar.go(progress);
            }
        }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

        $(".coverImage").draggable({
            scroll: false,
            axis: "y",
            drag: function (event, ui) {
                y1 = $('.cover-wrap').height();
                y2 = $('.coverImage').height();

                if (ui.position.top >= 0) {
                    ui.position.top = 0;
                }
                else
                    if (ui.position.top <= (y1-y2)) {
                        ui.position.top = y1-y2;
                    }
                },

                stop: function(event, ui) {
                    $('.cover-position').val(ui.position.top);
                    checkSize($(".coverImage").prop('naturalWidth'), $(".coverImage").prop('naturalHeight'));
                }
        });
    });
</script>

@endsection