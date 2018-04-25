<?php namespace App\Http\Models;

use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {

    use SoftDeletes;

	protected $fillable = array("body", "image", "user_id", "event_id");

    public function event(){
        return $this->belongsTo("App\\Http\\Models\\Event")->withTrashed();
    }

    public function user(){
        return $this->belongsTo("App\\Http\\Models\\User")->withTrashed();
    }

    public function comments(){
        return $this->hasMany("App\\Http\\Models\\Comment")->withTrashed();
    }

    public function getImage(){
        if($this->image){
            if(File::exists(public_path() . "/uploads/" . $this->image)){
                return "/uploads/" . $this->image;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function hashtags(){
        return $this->belongsToMany("App\\Http\\Models\\Hashtag");
    }

}
