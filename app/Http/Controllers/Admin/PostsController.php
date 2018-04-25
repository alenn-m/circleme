<?php namespace App\Http\Controllers\Admin;

use App\Http\Models\Post;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use File;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Response;
use URL;
use Validator;
use View;

class PostsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$posts = Post::paginate(20);
        return View::make("admin.posts.index")->with("posts", $posts);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make("posts.create");
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$post = Post::find($id);
        return View::make("admin.posts.edit")->with("post", $post);
	}

    public function update($id){
        $rules = array(
            "body" => "required"
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $post = Post::find($id);
            $post->body = Input::get("body");
            if(Input::file("image")){
                if(File::exists("/uploads/") . Input::get("image")){
                    $post->image = Input::get("image");
                }
            }

            $post->save();

            return Redirect::to(URL::action("Admin\PostsController@index"));
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
		$post = Post::withTrashed()->find($id);
        if($post){
            if(!Input::get("force")){
                $post->delete();
            }else{
                $post->comments()->delete();
                $post->forceDelete();
            }
        }

        return Redirect::to(URL::action("Admin\PostsController@index"));
	}

    /**
     * Restores selected post
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id){
        $post = Post::withTrashed()->find($id);
        $post->restore();

        return Redirect::back();
    }

    /**
     * Display trashed posts
     * @return \Illuminate\View\View
     */
    public function trash(){
        $posts = Post::onlyTrashed()->paginate(20);

        return View::make("admin.posts.trash", compact("posts"));
    }

}
