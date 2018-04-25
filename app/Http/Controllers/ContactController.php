<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Config;
use Illuminate\Http\Request;
use Input;
use Mail;
use Redirect;
use Validator;
use View;

class ContactController extends Controller {

	public function getContact(){
        return View::make("contact");
    }

    public function contact(){
        $rules = [
            "name" => "required|min:3",
            "email" => "required|email",
            "message" => "required|min:5"
        ];

        $validator = Validator::make(Input::all(), $rules);
        if($validator->passes()){
            $data["user"] = Input::get("user");
            if(!Input::has("subject")){
                $data["subject"] = trans("front.noSubject");
            }else{
                $data["subject"] = Input::get("subject");
            }
            Mail::queue('emails.contact', ["m" => Input::get("message"), "email" => Input::get("email"), "name" => Input::get("name")], function($message) use ($data){
                $message->to(Config::get("mail.from.address"), Config::get("mail.from.name"))->subject($data["subject"]);
            });

            return Redirect::back()->with("message", trans("front.messageSent"));
        }else{
            return Redirect::back()->withErrors($validator)->withInput();
        }
    }

}
