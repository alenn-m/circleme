<?php namespace App\Http\Controllers;

use App\Http\Models\Category;
use App\Http\Models\Circle;
use App\Http\Models\Event;
use App\Http\Models\Post;
use App\Http\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use ChrisKonnertz\OpenGraph\OpenGraph;
use Config;
use DB;
use File;
use Illuminate\Http\Request;
use Input;
use Mail;
use Redirect;
use Response;
use URL;
use Validator;
use View;

class EventsController extends Controller {

    public function __construct(){
        $this->middleware("auth", ["except" => "show"]);
    }

    public function search(){
        $text = "%" . Input::get("search") . "%";

        if(Input::get("search") != "::all::"){

            $users = User::where("username", "like", $text)->orWhere("fullname", "like", $text)->get();

        }else{
            if(!Input::get("circle")){
                $users = User::where("id", "!=", Auth::user()->id)->get();
            }else{
                if(Input::get("circle") != "all"){
                    $circle = Circle::find(Input::get("circle"));
                    $users = $circle->users()->where("users.id", "!=", Auth::user()->id)->get();
                }else{
                    $users = User::where("id", "!=", Auth::user()->id)->get();
                }
            }
        }

        $view = View::make("events.partials.search")
            ->with("users", $users)
            ->render();

        return Response::json(["response" => "ok", "view" => $view]);
    }

    public function selectedUsers(){
        $ids = null;
        $circle = "all";
        $circle_id = null;

        if(Input::get("circle")){
            $circle = Input::get("circle");
        }
        else if(Input::get("ids")){
            $ids = explode(",", Input::get("ids"));
        }else{
            return Response::json(["response" => "ok"]);
        }

        $users = null;
        if(is_array($ids) && count($ids) > 0){
            $users = User::whereIn("id", $ids)->get();
        }else if($circle){
            if($circle == "all"){
                $users = User::where("id", "!=", Auth::user()->id)->get();
            }else{
                $c = Circle::find($circle);
                $circle_id = $c->id;
                if($c){
                    $users = $c->users;
                }
            }
        }

        $view = View::make("events.partials.selectedUsers")
            ->with("users", $users)
            ->with("circle_id", $circle_id)
            ->render();


        return Response::json(["response" => "ok", "view" => $view]);
    }

    public function loadInviteModal(){
        $circle = "all";
        $users = null;
        $circles = null;

        if(Input::get("circle")){
            $circle = Input::get("circle");
        }

        $circles = Auth::user()->circles;

        if($circle == "all"){
            $users = User::where("id", "!=", Auth::user()->id)->get();
        }else{
            $c = Circle::find($circle);
            if($c){
                $users = $c->users;
            }
        }

        $view = View::make("events.partials.inviteUsers")
            ->with("circles", $circles)
            ->with("users", $users)
            ->render();

        return Response::json(["response" => "ok", "view" => $view]);
    }

    /**
     * Inviting users to specific event
     * @param $event
     * @return \Illuminate\Http\RedirectResponse
     * @internal param $users
     */
    public function invite($event){
        $users = null;
        if(Input::get("users")){
            $users = explode(",", Input::get("users"));
        }
        if(count($users) == 1){
            $check = DB::table("event_guests")->where("user_id", "=", $users)->where("event_id", "=", $event)->first();
            if(!count($check)){
                $usr = Auth::user()->getFullname();
                $evnt = Event::find($event);
                $title = $evnt->title;
                $event_url = URL::action("EventsController@show", $event);

                $toUser = User::find(Input::get("users"));

                $data = array();
                $data["email"] = $toUser->email;
                $data["username"] = $toUser->getFullname();

                Mail::queue('emails.invite', array("user" => $usr, "title" => $title, "event" => $event_url), function($message) use ($data){
                    $message->to($data['email'], $data['username'])->subject(trans("front.youAreInvited"));
                });

                DB::table("event_guests")->insert(["user_id" => Input::get("users"), "event_id" => $event, "type" => "invited"]);
            }
        }else if(count($users) > 1){
            foreach($users as $user){
                $check = DB::table("event_guests")->where("user_id", "=", $user)->where("event_id", "=", $event)->first();
                if(!count($check)){

                    $usr = Auth::user()->getFullname();
                    $evnt = Event::find($event);
                    $title = $evnt->title;
                    $event_url = URL::action("EventsController@show", $event);

                    $toUser = User::find($user);

                    $data = array();
                    $data["email"] = $toUser->email;
                    $data["username"] = $toUser->getFullname();


                    Mail::queue('emails.invite', array("user" => $usr, "title" => $title, "event" => $event_url), function($message) use ($data){
                        $message->to($data['email'], $data['username'])->subject(trans("front.youAreInvited"));
                    });

                    DB::table("event_guests")->insert(["user_id" => $user, "event_id" => $event, "type" => "invited"]);
                }
            }
        }

        return Redirect::back();
    }

    public function guests($event){

    }

    /**
     * Saves information and checks if user is going to event
     * @param $event
     * @param $answer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function isGoing($event, $answer){
        $check = DB::table("event_guests")->where("user_id", "=", Auth::user()->id)->where("event_id", "=", $event)->first();

        if(count($check)){
            if($check->type != $answer){
                DB::table("event_guests")->where("user_id", "=", Auth::user()->id)->where("event_id", "=", $event)->update(["type" => $answer]);
            }
        }else{
            DB::table("event_guests")->insert(["user_id" => Auth::user()->id, "event_id" => $event, "type" => $answer]);
        }

        return Redirect::back();
    }

    /**
     * Uploads image for event cover
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function uploadImage(){
        $file = Input::file('file');

        $size = correct_size($file);

        if($size){
            $destinationPath = public_path() . '/uploads';
            $extension = $file->getClientOriginalExtension();
            $filename = str_random(12) . "." . $extension;

            $file->move($destinationPath, $filename);
            return Response::json(["size" => "ok", "message" => $filename]);
        }else{
            return Response::json(["size" => "error", "message" => false]);
        }

    }

	public function myevents(){
        $events = Auth::user()->events()->orderBy("created_at", "desc")->paginate(Config::get("settings.eventsPerPage"));

        return View::make("events.myevents", compact("events"));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $categories = Category::all();
		return View::make("events.create")->with("categories", $categories);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
            "title" => "required|max:80",
            "date" => "sometimes|date",
            "hours" => "sometimes|integer",
            "minutes" => "sometimes|integer",
            "type" => "required|in:public,private"
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $event = new Event;
            $event->title = Input::get("title");
            $event->description = Input::get("description");

            if(Input::get("image")){
                $event->image = Input::get("image");

                if(Input::get("cover_position")){
                    $event->cover_position = Input::get("cover_position");
                }
            }
            $event->user_id = Auth::user()->id;

            $event->type = Input::get("type");

            if(Input::get("address")){
                $event->lat = Input::get("lat");
                $event->lng = Input::get("lng");

                if(Input::get("city")){
                    $event->city = Input::get("city");
                }

                if(Input::get("country")){
                    $event->country = Input::get("country");
                }
            }

            if(Input::get("time") && Input::get("time") != 0){
                $event->time = Input::get("time");
            }

            if(Input::get("date"))
                $event->date = Input::get("date");



            if(Input::get("eventoptions")){
                $event->guestCanInvite = false;
                $event->guestCanPublish = false;
                foreach(explode(",", Input::get("eventoptions")) as $option){
                    if($option == "guestCanInvite"){
                        $event->guestCanInvite = true;
                    }

                    if($option == "guestCanPublish"){
                        $event->guestCanPublish = true;
                    }
                }
            }

            $event->save();

            if(Input::get("categories")){
                $event->categories()->sync(Input::get("categories"));
            }

            return Redirect::to(URL::action("EventsController@show", $event->id));
        }else{
            return Redirect::back()->withInput()->withErrors($validator);
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, $slug = null)
	{
		$event = Event::find($id);
        $posts = $event->posts()->paginate(Config::get("settings.postsPerPage"));
        $isGoing = null;
        if(Auth::user())
            $isGoing = DB::table("event_guests")->where("event_id", "=", $event->id)->where("user_id", "=", Auth::user()->id)->first();

        $og = new OpenGraph();

        $og->title($event->title)
            ->type('place')
            ->image($event->getImage())
            ->description($event->description)
            ->url();

        $og->attributes("place", ["location:latitude" => $event->lat, "location:longitude" => $event->lng]);

        return View::make("events.show")
            ->with("event", $event)
            ->with("posts", $posts)
            ->with("isGoing", $isGoing)
            ->with("og", $og);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$event = Event::find($id);
        if(!Auth::user()->isAdmin() && (Auth::user()->id != $event->user_id)){
            return Redirect::to(URL::action("EventsController@show", $event->id));
        }
        $categories = Category::all();
        return View::make("events.edit")->with("event", $event)->with("categories", $categories);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $rules = array(
            "title" => "required|max:80",
            "date" => "sometimes|date",
            "hours" => "sometimes|integer",
            "minutes" => "sometimes|integer",
            "description" => "sometimes|max:300",
            "type" => "required|in:public,private"
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $event = Event::find($id);
            $event->title = Input::get("title");
            $event->description = Input::get("description");

            if(Input::get("image")){
                $event->image = Input::get("image");

                if(Input::get("cover_position")){
                    $event->cover_position = Input::get("cover_position");
                }
            }

            $event->type = Input::get("type");

            if(Input::get("address")){
                $event->lat = Input::get("lat");
                $event->lng = Input::get("lng");

                if(Input::get("city")){
                    $event->city = Input::get("city");
                }

                if(Input::get("country")){
                    $event->country = Input::get("country");
                }
            }

            if(Input::get("time") && Input::get("time") != 0){
                $event->time = Input::get("time");
            }

            if(Input::get("date"))
                $event->date = Input::get("date");


            if(Input::get("eventoptions")){
                $event->guestCanInvite = false;
                $event->guestCanPublish = false;
                foreach(explode(",", Input::get("eventoptions")) as $option){
                    if($option == "guestCanInvite"){
                        $event->guestCanInvite = true;
                    }

                    if($option == "guestCanPublish"){
                        $event->guestCanPublish = true;
                    }
                }
            }

            $event->save();

            $event->save();

            if(Input::get("categories")){
                $event->categories()->sync(Input::get("categories"));
            }

            return Redirect::to(URL::action("EventsController@show", $event->id));
        }else{
            return Redirect::back()->withInput()->withErrors($validator);
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$event = Event::find($id);
        if($event){
            $event->delete();
        }

        return Redirect::to(URL::action("HomeController@home"));
	}

    public function upcoming(){
        $events = Auth::user()->myEvents()->paginate(Config::get("settings.eventsPerPage"));
        $categories = Category::all();

        return View::make("events.calendar")
            ->with("events", $events)
            ->with("categories", $categories);
    }

    public function timeFilter(){
        $date1 = date('Y-m-d H:i:s', Input::get("from"));
        $date2 = date('Y-m-d H:i:s', Input::get("to"));

        $events = Auth::user()->eventsFiltered(Input::get("from"), Input::get("to"));

        $time = localDate($date1) . " - " . localDate($date2);

        return View::make("events.calendar", compact("events", "time"));
    }

    public function discover(){
        $joined = DB::table("event_guests")->where("user_id", "=", Auth::user()->id)->lists("event_id");
        $events = Event::whereNotIn("id", $joined)->where("date", ">=", DB::raw("NOW()"))->orderBy("date")->paginate(Config::get("settings.eventsPerPage"));
        $categories = Category::all();

        return View::make("events.calendar")
            ->with("events", $events)
            ->with("categories", $categories);
    }

    public function past(){
        $events = Auth::user()->myPastEvents()->paginate(Config::get("settings.eventsPerPage"));
        $categories = Category::all();

        return View::make("events.calendar")
            ->with("events", $events)
            ->with("categories", $categories);
    }

    public function byCategory($category){
        $category = Category::where("name", "=", $category)->first();
        $e = Auth::user()->myEvents()->lists("event_id");

        $events = $category->events()->whereIn("id", $e)->paginate(Config::get("settings.eventsPerPage"));

        $categories = Category::all();

        return View::make("events.calendar")
            ->with("events", $events)
            ->with("categories", $categories);
    }

    public function massMessage($id){
        $event = Event::find($id);

        // save posz
        $post = new Post;
        $post->user_id = Auth::user()->id;
        $post->event_id = $event->id;
        $post->body = Input::get("body");
        if(Input::get("image")){
            if(File::exists("/uploads/") . Input::get("image")){
                $post->image = Input::get("image");
            }
        }

        $post->save();


        $hashtags = getHashtags(Input::get("body"));
        if($hashtags[1] and count($hashtags[1]) > 0){
            foreach($hashtags[1] as $tag){
                $htag = Hashtag::firstOrCreate(["id" => $tag]);
            }

            $post->hashtags()->sync($hashtags[1]);
        }

        // send notification
        $users = null;
        $users = $event->allUsers;
        if(count($users) > 0){
            foreach($users as $user){
                Auth::user()->setNotification($user->id, "massmessage", $event->id . "#" . $post->id);
            }
        }


        // send email
        if(Config::get("mail.driver") == "mandrill"){
            $data["post"] = URL::action("EventsController@show", $event->id) . "#" . $post->id;
            $data["event"] = $event->title;
            $emails = array();
            foreach($users as $user){
                array_push($emails, $user->email);
            }

            Mail::queue('emails.massMessage', $data, function($message) use ($emails, $event) {
                foreach ($emails as $email) {
                    $message->to($email);
                }

                $message->subject(trans("front.youGotMessageinEvent") . " " . $event->title);

                $headers = $message->getHeaders();
                $headers->addTextHeader('X-MC-PreserveRecipients', 'false');
            });
        }

        return Redirect::to(URL::action("EventsController@show", $event->id));
    }

}
