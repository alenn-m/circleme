<?php namespace App\Http\Controllers;

use App\Http\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Http\Request;
use Input;
use Laravel\Socialite\Facades\Socialite;
use Redirect;
use URL;
use Validator;
use View;

class SocialLoginController extends Controller {

	public function social($provider){
        $allowed = array("facebook", "twitter", "google");

        if(!in_array($provider, $allowed)){
            return Redirect::to(URL::action("HomeController@home"));
        }
        if(Input::has("code") or Input::has("oauth_token")){
            $data = Socialite::with($provider)->user();

            $user = User::where($provider . "_id", "=", $data->getId())->first();

            if(count($user)){
                if($user->username and $user->email){
                    Auth::loginUsingId($user->id);
                }else{
                    return View::make("users.finishRegistration")->with("user", $user);
                }

                return Redirect::to(URL::action("HomeController@home"));
            }else{
                if($data->getEmail()){
                    $user = User::where("email", "=", $data->getEmail())->first();
                    if($user){
                        if($provider == "facebook"){
                            $user->facebook_id = $data->getId();
                        }

                        if($provider == "twitter"){
                            $user->twitter_id = $data->getId();
                        }

                        if($provider == "google"){
                            $user->google_id = $data->getId();
                        }
                    }
                    $user->save();

                    if($user->username and $user->email){
                        Auth::loginUsingId($user->id);
                    }else{
                        return View::make("users.finishRegistration")->with("user", $user);
                    }
                }
                $user = new User;
                if($provider == "facebook"){
                    $user->facebook_id = $data->getId();
                }

                if($provider == "twitter"){
                    $user->twitter_id = $data->getId();
                }

                if($provider == "google"){
                    $user->google_id = $data->getId();
                }
                $user->save();

                return View::make("users.finishRegistration")->with("user", $user);
            }
        }

        return Socialite::with($provider)->redirect();
    }

    public function finishRegistration($id){
        $rules = [
            "username" => "required|between:3,15|alpha_dash|unique:users",
            "email" => "required|email",
        ];

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $user = User::find($id);
            $user->username = Input::get("username");
            $user->email = Input::get("email");
            $user->active = 1;
            $user->save();

            Auth::loginUsingId($id);

            return Redirect::to(URL::action("HomeController@home"));
        }else{
            return View::make("users.finishRegistration")->with("user", User::find($id))->withErrors($validator);
        }
    }

}
