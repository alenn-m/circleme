<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Circle extends Model {

	protected $fillable = array("name", "user_id");

    public function users(){
        return $this->belongsToMany("App\\Http\\Models\\User");
    }

}
