<?php namespace App\Http\Controllers;

use App\Http\Models\Comment;
use App\Http\Models\Post;
use App\Http\Models\User;
use App\Http\Models\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Config;
use Cookie;
use Hash;
use Illuminate\Http\Request;
use Input;
use Mail;
use Redirect;
use Response;
use Session;
use URL;
use Validator;
use View;

class UsersController extends Controller {

    public function __construct(){
        $this->middleware("auth", ["only" => "edit"]);
    }

    public function allUsers(){
        return User::all();
    }

    public function updatePosition(){
        if(!Auth::user()->isAdmin()){
            $position = Input::get("cover_position");

            $user = Auth::user();
            $user->background_position = $position;
            $user->save();
        }

        return Redirect::back();
    }

    /**
     * Removed remembered user on login
     * @return mixed
     */
    public function clearLogin(){
        $cookie = Cookie::forget("user");

        return Response::json()->withCookie($cookie);
    }

    /**
     * Uploads background image for user profile
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function uploadBackground(){
        if(!Auth::user()->isAdmin()){
            $file = Input::file('file');

            $size = correct_size($file);

            if($size){
                $destinationPath = public_path() . '/backgrounds';
                $extension = $file->getClientOriginalExtension();
                $filename = str_random(12) . "." . $extension;

                $file->move($destinationPath, $filename);

                $user = Auth::user();
                $user->background = $filename;
                $user->save();

                return Response::json(["size" => "ok", "message" => $filename]);
            }else{
                return Response::json(["size" => "error", "message" => false]);
            }
        }
        return Response::json(["size" => "error", "message" => false]);

    }

    /**
     * Uploads avatar for user profile
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function uploadAvatar(){
        if(!Auth::user()->isAdmin()){
            $file = Input::file('file');

            $destinationPath = public_path() . '/avatars';
            $extension = $file->getClientOriginalExtension();
            $filename = str_random(12) . "." . $extension;

            $file->move($destinationPath, $filename);

            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        }

        return Response::json(["message" => $filename]);
    }

    /**
     * Displays login form
     * @return \Illuminate\View\View
     */
    public function login(){
        return View::make("login");
    }

    /**
     * Process login form
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(){
        $remember = Input::get("remember") ? true : false;

        if(Auth::attempt(["username" => Input::get("username"), "password" => Input::get("password")], $remember)){
            if(!Auth::user()->active){
                Auth::logout();
                return Redirect::back()->withMessage(trans("front.userNotActive"));
            }
            if(Auth::user()->banned){
                Auth::logout();
                return Redirect::back()->withMessage(trans("front.userBanned"));
            }
            if($remember){
                $data = array();
                $data["username"] = Auth::user()->username;
                $data["name"] = Auth::user()->getFullname();
                $data["image"] = Auth::user()->getAvatar();

                $cookie = Cookie::forever("user", $data);

                return Redirect::to("/")->withCookie($cookie);
            }
            return Redirect::to("/");
        }else{
            return Redirect::back()->withMessage(trans("front.loginNotCorrect"));
        }
    }

    /**
     * Displays signup form
     * @return \Illuminate\View\View
     */
    public function signup(){
        return View::make("signup");
    }


    /**
     * Process signUp form
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postSignup(){
        $rules = array(
            "username" => "required|between:3,15|alpha_dash|unique:users",
            "email" => "required|email|unique:users",
            "password" => "required|min:4|confirmed",
            "password_confirmation" => "min:4",
            "terms" => "required"
        );

        if(hasRecaptcha()){
            $rules['g-recaptcha-response'] = 'required|recaptcha';
        }

        $messages = ["terms.requred" => trans("front.terms")];

        $validator = Validator::make(Input::all(), $rules, $messages);
        $code = str_random(30);

        if($validator->passes()){
            $user = new User;
            $user->username = Input::get("username");
            $user->email = Input::get("email");
            $user->password = Hash::make(Input::get("password"));
            $user->code = $code;
            $user->save();

            $user->checkInvite();

            $data['email'] = Input::get('email');
            $data['username'] = Input::get('username');
            Mail::queue('emails.validateEmail', array("username" => Input::get("username"), "code" => $code), function($message) use ($data){
                $message->to($data['email'], $data['username'])->subject(trans("front.validateEmailAddress"));
            });

            Session::flash("message", trans("front.successRegister"));
            return Redirect::to(URL::action("UsersController@signup"));
        }else{
            return Redirect::back()->withErrors($validator)->withInput();
        }
    }

    public function getValidate(){
        if(Input::has("code") && Input::has("username")){
            $user = User::where("code", "=", Input::get("code"))
                ->where("username", "=", Input::get("username"));
            if($user->count()){
                $user = $user->first();

                $user->active = 1;
                $user->code = "";
                Auth::loginUsingId($user->id);
                $user->save();

                return Redirect::to("/");
            }
        }else{
            Session::flash("errorMessage", trans("front.activationLinkNotValid"));
            return Redirect::to("/");
        }
    }

    /**
     * Logs out user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(){
        Auth::logout();

        return Redirect::to(URL::action("HomeController@home"));
    }

    /**
     * Show form for editing profile
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id){
        $user = User::find($id);

        if(Auth::user()->id == $user->id){
            return View::make("users.edit", compact("user"));
        }

        return Redirect::back();
    }

    public function update($id){
        $user = User::find($id);

        if(Auth::user() and Auth::user()->id == $user->id){
            if(!Auth::user()->isAdmin()){
                $user->about = Input::get("about");
                if(Input::get("showmail")){
                    $user->showmail = true;
                }else{
                    $user->showmail = false;
                }

                $user->location = Input::get("location");
                $user->fullname = Input::get("fullname");

                $user->save();
            }

            return Redirect::to(URL::action("UsersController@show", $user->username));
        }else{
            return Redirect::to(URL::action("HomeController@home"));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $username
     * @return Response
     * @internal param int $id
     */
    public function show($username)
    {
        $user = User::where("username", "=", $username)->first();
        $events = $user->events()->paginate(20);
        $circles = null;
        if(Auth::user()){
            $circles = Auth::user()->circles;
        }

        $b = $user->circle;

        $belongsTo = array();

        if(count($b) > 0){
            foreach($b as $ba){
                array_push($belongsTo, $ba->id);
            }
        }

        return View::make("users.show")
            ->with("user", $user)
            ->with("events", $events)
            ->with("circles", $circles)
            ->with("belongsTo", $belongsTo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if($id == Auth::user()->id){
            if(!Auth::user()->isAdmin()){
                $user = User::find($id);

                Event::where("user_id", "=", $user->id)->delete();
                Post::where("user_id", "=", $user->id)->delete();
                Comment::where("user_id", "=", $user->id)->delete();

                Auth::logout();
                $user->delete();
            }
        }

        return Redirect::to(URL::action("HomeController@home"));
    }

}

