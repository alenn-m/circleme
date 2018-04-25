<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

	public function user(){
        return $this->belongsTo("App\\Http\\Models\\User");
    }

}
