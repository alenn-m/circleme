<?php namespace App\Http\Controllers;

use App\Http\Models\Event;
use App\Http\Models\Post;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use View;

class ImagesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
        $event = Event::find($id);
		$images = Post::where("event_id", "=", $event->id)->get();
        return View::make("events.images.index", compact("images"))->with("event", $event);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$post = Post::find($id);

        $event = $post->event;

        $total = count($post->event->posts);
        $previous = Post::where('id', '<', $post->id)->where("event_id", "=", $event->id)->max('id');
        $next = Post::where('id', '>', $post->id)->where("event_id", "=", $event->id)->min('id');

        $tPrevious = count(Post::where('id', '<', $post->id)->where("event_id", "=", $event->id)->get());

        $position = $tPrevious + 1;

        return View::make("events.images.show")
            ->with("post", $post)
            ->with("total", $total)
            ->with("next", $next)
            ->with("previous", $previous)
            ->with("position", $position);
	}

}
