<?php namespace App\Http\Controllers;

use App\Http\Models\Category;
use App\Http\Models\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Config;
use DB;
use Illuminate\Http\Request;
use View;

class HomeController extends Controller {

    /**
     * Displays home page
     * @return \Illuminate\View\View
     */
    public function home(){

        $geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR']) );
        $lat = $geoplugin['geoplugin_latitude'];
        $long = $geoplugin['geoplugin_longitude'];

        $events = Event::select(DB::raw("*, (
            3959 * acos (
              cos ( radians($lat) )
              * cos( radians( lat ) )
              * cos( radians( lng ) - radians($long) )
              + sin ( radians($lat) )
              * sin( radians( lat ) )
            )
          ) AS distance"))
            ->where("type", "=", "public")
            ->where("date", ">=", DB::raw("CURDATE()"))
            ->orderBy("distance")
            ->orderBy("date")
            ->paginate(Config::get("settings.eventsPerPage"));

        return View::make("home")->with("events", $events);
    }

    public function category($id){
        $category = Category::find($id);

        $geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR']) );
        $lat = $geoplugin['geoplugin_latitude'];
        $long = $geoplugin['geoplugin_longitude'];

        $events = $category->events()->select(DB::raw("*, (
            3959 * acos (
              cos ( radians($lat) )
              * cos( radians( lat ) )
              * cos( radians( lng ) - radians($long) )
              + sin ( radians($lat) )
              * sin( radians( lat ) )
            )
          ) AS distance"))
            ->where("type", "=", "public")
            ->where("date", ">=", DB::raw("CURDATE()"))
            ->orderBy("distance")
            ->orderBy("date")
            ->paginate(Config::get("settings.eventsPerPage"));

        return View::make("home")->with("events", $events)->with("cat", $category->id);
    }

}
