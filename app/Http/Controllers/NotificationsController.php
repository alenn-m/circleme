<?php namespace App\Http\Controllers;

use App\Http\Models\Notification;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Http\Request;
use Response;
use View;

class NotificationsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$notifications = Notification::where("target_id", "=", Auth::user()->id)->orderBy("created_at", "desc")->get();
        return View::make("notifications.index")->with("notifications", $notifications);
	}


    /**
     * Updates all notifications to 'seen' when users clicks on notification icon
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function seenNotification(){
        Notification::where("target_id", "=", Auth::user()->id)->update(["seen" => 1]);
        return Response::json(["response" => "ok"]);
    }

}
