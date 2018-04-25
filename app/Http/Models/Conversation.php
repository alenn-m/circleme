<?php namespace App\Http\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model {

	public function users(){
        return $this->belongsToMany("App\\Http\\Models\\User");
    }

    public function messages(){
        return $this->hasMany("App\\Http\\Models\\Message");
    }

    public function otherUser(){
        return $this->belongsToMany("App\\Http\\Models\\User")->where("user_id", "!=", Auth::user()->id)->withPivot("opened");
    }

}
