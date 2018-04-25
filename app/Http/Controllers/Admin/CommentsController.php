<?php namespace App\Http\Controllers\Admin;

use App\Http\Models\Comment;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Input;
use Redirect;
use URL;
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
		$comments = Comment::paginate(20);
        return View::make("admin.comments.index", compact("comments"));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$comment = Comment::find($id);
        return View::make("admin.comments.edit")->with("comment", $comment);
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
            $comment->comment = Input::get("comment");
            $comment->save();

            return Redirect::to(URL::action("Admin\CommentsController@index"));
        }else{
            return Redirect::back()->withInput()->withErrors($validator);
        }
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $comment = Comment::withTrashed()->find($id);
        if($comment){
            if(!Input::get("force")){
                $comment->delete();
            }else{
                $comment->forceDelete();
            }
        }

        return Redirect::to(URL::action("Admin\CommentsController@index"));
    }

    /**
     * Restores selected post
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id){
        $comment = Comment::withTrashed()->find($id);
        $comment->restore();

        return Redirect::back();
    }

    /**
     * Display trashed posts
     * @return \Illuminate\View\View
     */
    public function trash(){
        $comments = Comment::onlyTrashed()->paginate(20);

        return View::make("admin.comments.trash", compact("comments"));
    }

}
