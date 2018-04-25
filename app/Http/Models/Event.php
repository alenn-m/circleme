<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Event extends Model implements SluggableInterface{

    use SoftDeletes, SluggableTrait;

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

	public function user(){
        return $this->belongsTo("App\\Http\\Models\User")->withTrashed();
    }

    public function posts(){
        return $this->hasMany("App\\Http\\Models\\Post")->orderBy("created_at", "desc")->with("comments")->withTrashed();
    }

    public function getImage(){

        if($this->image){
            return "/uploads/" . $this->image;
        }else{
            return "img/cover.jpeg";
        }
    }

    public function hasImages(){
        $posts = Post::where("event_id", "=", $this->id)->whereNotNull("image")->get();

        return count($posts);
    }

    public function getImages(){
        $posts = Post::where("event_id", "=", $this->id)->orderBy("created_at", "desc")->take(2)->get();
        return $posts;
    }

    public function countImages(){
        $posts = Post::where("event_id", "=", $this->id)->get();
        $images = array();

        foreach($posts as $post){
            array_push($images, $post->getImage());
        }

        return count(array_filter($images));
    }

    public function going(){
        return $this->belongsToMany("App\\Http\\Models\\User", "event_guests")->wherePivot("type", "=", "yes");
    }

    public function notgoing(){
        return $this->belongsToMany("App\\Http\\Models\\User", "event_guests")->wherePivot("type", "=", "no");
    }

    public function maybegoing(){
        return $this->belongsToMany("App\\Http\\Models\\User", "event_guests")->wherePivot("type", "=", "maybe");
    }

    public function categories(){
        return $this->belongsToMany("App\\Http\\Models\\Category");
    }

    public function allUsers(){
        return $this->belongsToMany("App\\Http\\Models\\User", "event_guests");
    }

}
