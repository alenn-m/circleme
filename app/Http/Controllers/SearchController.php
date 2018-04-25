<?php namespace App\Http\Controllers;

use App\Http\Models\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Config;
use DB;
use Illuminate\Http\Request;
use Input;
use View;

class SearchController extends Controller {

	public function search(){
        $text = Input::get("search");

        $string = "%" . $text . "%";

        $countries = Config::get("countries");
        $states = array_map('strtolower', $countries);
        $state = 0;
        $dbCities = array_filter(array_unique(Event::lists("city")));

        foreach($states as $str){

            if(strpos(strtolower($text), strtolower($str))){
                $state = $countries[ucwords($str)];
            }else if(startsWith(strtolower($text), strtolower($str))){
                $state = $countries[ucwords($str)];
            }
        }

        $city = 0;

        foreach($dbCities as $c){
            if(strpos(strtolower($text), strtolower($c))){
                $city = $c;
            }else if(startsWith(strtolower($text), strtolower($c))){
                $city = $c;
            }
        }

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
            ->where("title", "like", $string)
            ->where("type", "=", "public")
            ->where("date", ">=", DB::raw("CURDATE()"))
            ->orWhere("country", "like", "%". $state. "%")
            ->orWhere("city", "like", "%". $city. "%")
            ->orderBy("date")
            ->orderBy("distance")
            ->paginate(Config::get("settings.eventsPerPage"));

        return View::make("home")->with("events", $events)->with("title", trans("front.searchResults"));

    }

}
