<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model {

    use SoftDeletes;

	public function user(){
        return $this->belongsTo("App\\Http\\Models\\User")->withTrashed();
    }

    public function post(){
        return $this->belongsTo("App\\Http\\Models\\Post")->withTrashed();
    }

}
