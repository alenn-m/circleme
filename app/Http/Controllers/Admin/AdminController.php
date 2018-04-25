<?php namespace App\Http\Controllers\Admin;

use App\Http\Models\Comment;
use App\Http\Models\Event;
use App\Http\Models\Post;
use App\Http\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Response;
use View;

class AdminController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $users = array();
        $users["total"] = count(User::all());
        $users["banned"] = count(User::where("banned", "=", 1)->get());
        $users["innactive"] = count(User::where("active", "=", 0)->get());

        $events = array();
        $events["total"] = count(Event::all());
        $events["public"] = count(Event::where("type", "=", "public")->get());
        $events["private"] = count(Event::where("type", "=", "private")->get());

        $posts = count(Post::all());

        $comments = count(Comment::all());

		return View::make("admin.index", compact("users", "events", "posts", "comments", "dates"));
	}

    public function fetchData(){
        $period = new DatePeriod(
            new DateTime(Carbon::today()->subDays(6)),
            new DateInterval('P1D'),
            new DateTime(Carbon::tomorrow())
        );

        $dates = array();
        foreach($period as $p){
            array_push($dates, $p->format("Y-m-d"));
        }

        $d_events = Event::select(DB::raw("DATE(created_at) as date"), DB::raw("count(DATE(created_at)) as cnt"))->whereIn(DB::raw("DATE(created_at)"), $dates)->groupBy(DB::raw("DATE(created_at)"))->lists("cnt", "date");
        $d_users = User::select(DB::raw("DATE(created_at) as date"), DB::raw("count(DATE(created_at)) as cnt"))->whereIn(DB::raw("DATE(created_at)"), $dates)->groupBy(DB::raw("DATE(created_at)"))->lists("cnt", "date");
        $d_posts = Post::select(DB::raw("DATE(created_at) as date"), DB::raw("count(DATE(created_at)) as cnt"))->whereIn(DB::raw("DATE(created_at)"), $dates)->groupBy(DB::raw("DATE(created_at)"))->lists("cnt", "date");
        $d_comments = Comment::select(DB::raw("DATE(created_at) as date"), DB::raw("count(DATE(created_at)) as cnt"))->whereIn(DB::raw("DATE(created_at)"), $dates)->groupBy(DB::raw("DATE(created_at)"))->lists("cnt", "date");

        $data = array();
        foreach($dates as $date){
            $sub = array();


            $sub["date"] = noYear($date);
            if(in_array($date, array_keys($d_users))){
                $sub["users"] = $d_users[$date];
            }else{
                $sub["users"] = "0";
            }

            if(in_array($date, array_keys($d_events))){
                $sub["events"] = $d_events[$date];
            }else{
                $sub["events"] = "0";
            }

            if(in_array($date, array_keys($d_posts))){
                $sub["posts"] = $d_posts[$date];
            }else{
                $sub["posts"] = "0";
            }

            if(in_array($date, array_keys($d_comments))){
                $sub["comments"] = $d_comments[$date];
            }else{
                $sub["comments"] = "0";
            }

            array_push($data, $sub);

        }

        return Response::json(["data" => $data]);
    }

    public function getStats(){
        $users = User::orderBy("created_at", "desc")->get()->take(5);
        $events = Event::orderBy("created_at", "desc")->get()->take(5);
        $posts = Post::orderBy("created_at", "desc")->get()->take(5);
        $comments = Comment::orderBy("created_at", "desc")->get()->take(5);

        $view = View::make("admin.partials.stats", compact("users", "events", "posts", "comments"))->render();

        return Response::json(["view" => $view]);
    }

}
