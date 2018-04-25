<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	public function events(){
        return $this->belongsToMany("App\\Http\\Models\\Event")->where("date", ">=", \DB::raw("NOW()"))->orderBy("date")->withTrashed();
    }

    public function allEvents(){
        return $this->belongsToMany("App\\Http\\Models\\Event");
    }

}
