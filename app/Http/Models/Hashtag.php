<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model {

    protected $fillable = ["name"];

	public function posts(){
        return $this->belongsToMany("App\\Http\\Models\\Post");
    }

}
