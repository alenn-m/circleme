<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

	public function conversation(){
        return $this->belongsTo("App\\Http\\Models\\Conversation");
    }

    public function user(){
        return $this->belongsTo("App\\Http\\Models\\User");
    }

}
