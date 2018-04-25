<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model {

	protected $table = "invites";

    public function getCircles(){
        $data = $this->circles;
        $names = array();
        if($data and count(explode(",", $data)) > 0){
            $circles = Circle::whereIn("id", explode(",", $data))->get();

            foreach($circles as $circle){
                array_push($names, $circle->name);
            }
        }

        if(count($names) > 0){
            return implode(", ", $names);
        }else{
            return null;
        }
    }

}
