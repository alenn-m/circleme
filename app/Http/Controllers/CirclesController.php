<?php namespace App\Http\Controllers;

use App\Http\Models\Circle;
use App\Http\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use DB;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Response;
use Validator;
use View;

class CirclesController extends Controller {

    /**
     * Remove user from circle
     * @param $id
     * @param $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function exitCircle($id, $user){
        DB::table("circle_user")->where("circle_id", "=", $id)->where("user_id", "=", $user)->delete();

        $count = count(DB::table("circle_user")->where("circle_id", "=", $id)->get());

        return Response::json(["response" => "ok", "count" => $count]);
    }

    /**
     * Add user to your circle
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addUser(){
        $circle = Input::get("circle");
        $user = Input::get("user");

        $remove = false;
        if(Input::get("remove")){
            $remove = true;
        }

        $check = DB::table("circle_user")->where("circle_id", "=", $circle)->where("user_id", "=", $user)->get();

        if($check and $remove){
            DB::table("circle_user")->where("circle_id", "=", $circle)->where("user_id", "=", $user)->delete();
        }

        if(!count($check)){
            DB::table("circle_user")->insert(["circle_id" => $circle, "user_id" => $user]);
        }

        $count = count(DB::table("circle_user")->where("circle_id", "=", $circle)->get());

        return Response::json(["response" => "ok", "count" => $count]);
    }

    /**
     * Find users which are not in your circles
     * @return \Illuminate\View\View
     */
    public function findpeople(){
        $circles = Auth::user()->circles;
        $c_ids = array();
        foreach($circles as $circle){
            array_push($c_ids, $circle->id);
        }

        $data = DB::table("circle_user")->whereIn("circle_id", $c_ids)->get();
        $u_ids = array();

        foreach($data as $d){
            array_push($u_ids, $d->user_id);
        }

        $users = User::whereNotIn("id", $u_ids)->where("id", "!=", Auth::user()->id)->get();
        return View::make("circles.find")->with("users", $users);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $circles = Auth::user()->circles;
        $c_ids = array();
        foreach($circles as $circle){
            array_push($c_ids, $circle->id);
        }

        $data = DB::table("circle_user")->whereIn("circle_id", $c_ids)->get();
        $u_ids = array();

        foreach($data as $d){
            array_push($u_ids, $d->user_id);
        }

        $users = User::whereIn("id", $u_ids)->get();
        return View::make("circles.index")->with("users", $users);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
            "name" => "required"
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $circle = new Circle;
            $circle->user_id = Auth::user()->id;
            $circle->name = Input::get("name");
            $circle->description = Input::get("description");

            $circle->save();

            return Response::json(["response" => "ok"]);
        }else{
            return Response::json(["response" => "error", "errors" => $validator->messages()]);
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$circle = Circle::find($id);
        $view = View::make("circles.partials.profiles")
            ->with("users", $circle->users)
            ->with("circle", $circle)
            ->render();
        return Response::json(["view" => $view]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$circle = Circle::find($id);

        $view = View::make("circles.partials.edit")->with("circle", $circle)->render();

        return Response::json(["response" => "ok", "view" => $view]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $rules = array(
            "name" => "required"
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $circle = Circle::find($id);
            $circle->user_id = Auth::user()->id;
            $circle->name = Input::get("name");
            $circle->description = Input::get("description");

            $circle->save();

            return Redirect::back();
        }else{
            return Redirect::back();
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$circle = Circle::find($id);
        if($circle->user_id == Auth::user()->id){

            DB::table("circle_user")->where("circle_id", "=", $circle->id)->delete();;

            $circle->delete();
        }


        return Redirect::back();
	}

}
