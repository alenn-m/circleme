<?php namespace App\Http\Controllers;

use App\Http\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Config;
use Hash;
use Illuminate\Http\Request;
use Input;
use Mail;
use Redirect;
use Response;
use URL;
use Validator;
use View;

class SettingsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $user = Auth::user();
		return View::make("settings.index")
            ->with("user", $user);
	}

    public function email(){
        $email = Input::get("email");
        $rules = ["email" => "required|email|unique:users"];

        if(count(User::where("email", "=", $email)->where("id", "=", Auth::user()->id)->first()) > 0){
            return Response::json(["changed" => false, "response" => "ok"]);
        }

        $validator = Validator::make(Input::all(), $rules);
        if($validator->passes()){

            $code = str_random(30);
            $u = User::find(Auth::user()->id);
            $u->code = $code;
            $u->save();
            $data["email"] = Input::get("email");
            $data["user"] = Auth::user()->username;
            Mail::queue('emails.confirmEmail', array(
                "username" => Auth::user()->username,
                "code" => $code,
                "email" => $email
            ), function($message) use ($data){
                $message->to($data["email"], $data["user"])->subject(trans("front.confirmEmailAddress"));
            });

            return Response::json(["changed" => true, "response" => "ok"]);
        }else{
            return Response::json(["response" => "error", "errors" => $validator->messages()]);
        }
    }

    public function confirmEmail(){
        if(Input::get("code") && Input::get("username") && Input::get("email")){
            if(count(User::where("code", "=", Input::get("code"))->where("username", "=", Input::get("username"))->first()) > 0){
                $user = User::where("code", "=", Input::get("code"))->where("username", "=", Input::get("username"))->first();
                $user->email = Input::get("email");
                $user->save();

                return View::make("settings.index")->with("user", $user)
                    ->with("message", trans("front.emailIsUpdated"))
                    ->withTitle(trans("front.settings"));
            }else{
                return View::make("settings.index")
                    ->with("message", trans("front.activationLinkNotValid"))
                    ->withTitle(trans("front.settings"));
            }
        }else{
            return Redirect::to(URL::action("HomeController@home"));
        }
    }

    public function password(){
        $rules = [
            "current_password" => "required",
            "new_password" => "required",
            "password_confirmation" => "required|same:new_password"
        ];

        $validator = Validator::make(Input::all(), $rules);
        if($validator->passes()){
            $user = User::find(Auth::user()->id);
            if(Hash::check(Input::get("current_password"), Auth::user()->getAuthPassword())){
                $user->password = Hash::make(Input::get("new_password"));
                $user->save();
                return View::make("settings.index")->with("alert", trans("front.passwordIsChanged"))->with("user", $user);
            }else{
                return View::make("settings.index")->with("alert", trans("front.passwordIsNotCorrect"))->with("user", $user);
            }
        }else{
            return Redirect::to(URL::action("SettingsController@index"))->withErrors($validator);
        }
    }

    public function passwordCreate(){
        $rules = [
            "new_password" => "required",
            "password_confirmation" => "required|same:new_password"
        ];

        $validator = Validator::make(Input::all(), $rules);
        if($validator->passes()){
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make(Input::get("new_password"));
            $user->save();
            return View::make("settings.index")->with("alert", trans("front.passwordIsSaved"))->with("user", $user);
        }else{
            return Redirect::to(URL::action("SettingsController@index"))->withErrors($validator);
        }
    }


}
