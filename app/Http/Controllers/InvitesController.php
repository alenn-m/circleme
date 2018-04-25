<?php namespace App\Http\Controllers;

use App\Http\Models\Circle;
use App\Http\Models\Invite;
use App\Http\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Http\Request;
use Input;
use Mail;
use Redirect;
use URL;
use Validator;
use View;
use Session;

class InvitesController extends Controller {

	public function index(){
        $invites = Auth::user()->invites;
        $circles = Auth::user()->circles;

        return View::make("invites.index", compact("invites", "circles"));
    }

    public function invite(){
        $rules = [
            "email" => "required|email",
            "circles" => "required|min:1"
        ];



        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){

            $user = User::where("email", "=", Input::get("email"))->first();
            if($user){
                Session::flash("message", trans("front.userIsRegistered"));
                return Redirect::back();
            }

            $invite = new Invite;
            $invite->user_id = Auth::user()->id;
            $invite->email = Input::get("email");
            $invite->circles = implode(Input::get("circles"), ",");

            $invite->save();

            $usr = Auth::user()->getFullname();
            $register_url = URL::action("UsersController@signup");

            $to = Input::get("email");

            Mail::queue('emails.invite2', array("user" => $usr, "register" => $register_url), function($message) use ($to){
                $message->to($to)->subject(trans("front.youAreInvited"));
            });

            return Redirect::back();
        }else{
            return Redirect::back()->withInput()->withErrors($validator);
        }
    }

}
