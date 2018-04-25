<?php namespace App\Http\Controllers;

use App\Http\Models\Hashtag;
use App\Http\Models\Post;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Config;
use File;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Response;
use Validator;
use View;

class PostsController extends Controller {

    /**
     * Uploads post image
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function uploadImage(){
        $file = Input::file('file');

        $destinationPath = public_path() . '/uploads';
        $extension = $file->getClientOriginalExtension();
        $filename = str_random(12) . "." . $extension;

        $file->move($destinationPath, $filename);
        return Response::json(["message" => $filename]);
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
            "event_id" => "required|integer"
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $post = new Post;
            $post->user_id = Auth::user()->id;
            $post->event_id = Input::get("event_id");
            $post->body = Input::get("body");
            if(Input::get("image")){
                if(File::exists("/uploads/") . Input::get("image")){
                    $post->image = Input::get("image");
                }
            }

            if(Input::get("image") or Input::get("body")){
                $post->save();

                $hashtags = getHashtags(Input::get("body"));
                if($hashtags[1] and count($hashtags[1]) > 0){
                    foreach($hashtags[1] as $tag){
                        $htag = Hashtag::firstOrCreate(["id" => $tag]);
                    }

                    $post->hashtags()->sync($hashtags[1]);
                }

                return Response::json(["response" => "ok", "type" => "store"]);
            }else{
                return Response::json(["response" => "error"]);
            }

        }else{
            return Response::json(["response" => "error"]);
        }
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
            "body" => "required"
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $post = Post::find($id);
            $post->body = Input::get("body");
            $post->save();

            return Response::json(["response" => "ok", "type" => "update", "id" => $post->id]);
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
		$post = Post::find($id);
        $image = $post->getImage();
        if($image){
            File::delete($image);
        }
        if($post){
            if(Auth::user() && Auth::user()->id == $post->user_id){
                $post->comments()->delete();
                $post->delete();
            }
        }

        return Redirect::back();
	}

    /**
     * Show posts with specific hashtag
     * @param $hashtag
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function byHashtag($hashtag){
        $htag = Hashtag::where("id", "=", $hashtag)->first();

        if($htag){
            $posts = $htag->posts()->paginate(Config::get("settings.postsPerPage"));

            return View::make("hashtag")->with("posts", $posts)->with("hashtag", $hashtag);
        }else{
            return Redirect::to(URL::action("HomeController@home"));
        }
    }

}
