<?php namespace App\Http\Controllers;

use App\Http\Models\Conversation;
use App\Http\Models\Message;
use App\Http\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Config;
use DB;
use Illuminate\Http\Request;
use Input;
use Redirect;
use URL;
use Validator;
use View;

class ConversationsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $conversations = Auth::user()->conversations;
		return View::make("conversations.index")->with("conversations", $conversations);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @param $username
     * @return Response
     */
	public function create($username)
	{
        $user = User::where("username", "=", $username)->first();
		return View::make("conversations.create")->with("user", $user);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = ["message" => "required", "user" => "required|integer"];

        $validator = Validator::make(Input::all(), $rules);
        $user = User::find(Input::get("user"));

        if($validator->passes()){
            $conv1 = Auth::user()->conversations->lists("id");
            $conv2 = $user->conversations->lists("id");

            if(count(array_intersect($conv1, $conv2)) > 0){
                $conversation = Conversation::find(array_intersect($conv1, $conv2)[0]);
            }else{
                $conversation = new Conversation;
                $conversation->save();
                $conversation->users()->attach([Auth::user()->id, $user->id]);
            }

            $message = new Message;
            $message->user_id = Auth::user()->id;
            $message->message = Input::get("message");
            $message->conversation_id = $conversation->id;
            $message->save();

            return Redirect::to(URL::action("ConversationsController@show", $conversation->id));
        }else{
            return Redirect::back()->withInput()->withErrors($validator);
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $conversation = Conversation::find($id);
		$messages = $conversation->messages()->orderBy("created_at", "desc")->paginate(Config::get("settings.messagesPerPage"));
        $conversations = Auth::user()->conversations;
        return View::make("conversations.show")
            ->with("messages", $messages)
            ->with("conversations", $conversations)
            ->with("conversation", $conversation);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$conversation = Conversation::find($id);
        $conversation->messages()->delete();

        $conversation->delete();

        return Redirect::to(URL::action("ConversationsController@index"));
	}

    public function storeMessage(){
        $rules = [
            "message" => "required",
            "conversation" => "required|integer"
        ];

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $message = new Message;
            $message->conversation_id = Input::get("conversation");
            $message->user_id = Auth::user()->id;
            $message->message = Input::get("message");

            $message->save();

            $conversation = Conversation::find(Input::get("conversation"));
            $conversation->updated_at = $message->created_at;
            $conversation->save();

            DB::table("conversation_user")
                ->where("conversation_id", "=", Input::get("conversation"))
                ->where("user_id", "!=", Auth::user()->id)
                ->update(["opened" => "0"]);


            return Redirect::back();
        }else{
            return Redirect::back();
        }
    }

}
