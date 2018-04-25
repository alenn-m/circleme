<?php namespace App\Http\Controllers;

use App\Http\Models\Comment;
use App\Http\Models\Post;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Input;
use Validator;
use View;

class CommentsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
            "comment" => "required",
            "post_id" => "required|integer"
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $comment = new Comment;
            $comment->user_id = Auth::user()->id;
            $comment->post_id = Input::get("post_id");
            $comment->comment = Input::get("comment");

            $comment->save();

            $view = View::make("events.partials.singleComment")->with("comment", $comment)->with("post", Post::find(Input::get("post_id")))->render();

            return Response::json(["response" => "ok", "type" => "store", "view" => $view]);
        }else{
            return Response::json(["response" => "error"]);
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
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $rules = array(
            "comment" => "required",
            "post_id" => "required|integer"
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $comment = Comment::find($id);
            $comment->user_id = Auth::user()->id;
            $comment->post_id = Input::get("post_id");
            $comment->comment = Input::get("comment");

            $comment->save();

            $view = View::make("events.partials.singleComment")->with("comment", $comment)->with("post", Post::find(Input::get("post_id")))->render();

            return Response::json(["response" => "ok", "type" => "update", "view" => $view, "id" => $comment->id]);
        }else{
            return Response::json(["response" => "error"]);
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$comment = Comment::find($id);
        if($comment && $comment->user_id == Auth::user()->id){
            $comment->delete();
        }

        return Response::json(["response" => "ok"]);
	}

}
