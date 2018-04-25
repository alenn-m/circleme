<?php namespace App\Http\Controllers\Admin;

use App\Http\Models\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Input;
use Redirect;
use URL;
use View;

class EventsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$events = Event::paginate(20);
        return View::make("admin.events.index")->with("events", $events);
	}

    /**
     * Restores selected event
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id){
        $event = Event::withTrashed()->find($id);
        $event->restore();

        return Redirect::back();
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$event = Event::withTrashed()->find($id);
        if(Input::get("force")){
            $event->forceDelete();
        }else{
            $event->delete();
        }

        return Redirect::to(URL::action("Admin\EventsController@index"));
	}

    /**
     * Display trashed events
     * @return \Illuminate\View\View
     */
    public function trash(){
        $events = Event::onlyTrashed()->paginate(20);

        return View::make("admin.events.trash", compact("events"));
    }

}
