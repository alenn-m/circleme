<?php namespace App\Http\Controllers\Admin;

use App\Http\Models\Comment;
use App\Http\Models\Event;
use App\Http\Models\Post;
use App\Http\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Hash;
use Illuminate\Http\Request;
use Input;
use Redirect;
use URL;
use Validator;
use View;

class UsersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::paginate(20);
        return View::make("admin.users.index")->with("users", $users);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make("admin.users.create");
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [
            "username" => "required|min:3|alpha",
            "email" => "required|email",
            "password" => "required|min:5",
            "role" => "required|in:user, admin",
            "avatar" => "sometimes|image",
            "background" => "sometimes|image"
        ];

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $user = new User;
            $user->username = Input::get("username");
            $user->password = Hash::make(Input::get("password"));
            $user->email = Input::get("password");
            if(Input::get("active")){
                $user->active = true;
            }
            $user->about = Input::get("about");
            $user->role = Input::get("role");

            $file = Input::file('background');

            $destinationPath = public_path() . '/backgrounds';
            $extension = $file->getClientOriginalExtension();
            $filename = str_random(12) . "." . $extension;

            $file->move($destinationPath, $filename);

            $user->background = $filename;

            $file = Input::file('avatar');

            $destinationPath = public_path() . '/avatars';
            $extension = $file->getClientOriginalExtension();
            $filename = str_random(12) . "." . $extension;

            $file->move($destinationPath, $filename);

            $user->avatar = $filename;

            $user->save();

            return Redirect::to(URL::action("Admin\UsersController@index"));
        }else{
            return Redirect::back()->withInput()->withErrors($validator);
        }
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);
        return View::make("admin.users.edit")->with("user", $user);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $rules = [
            "username" => "required|min:3|alpha_dash",
            "email" => "required|email",
            "password" => "sometimes|min:5",
            "role" => "required|in:user,admin",
            "avatar" => "sometimes|image",
            "background" => "sometimes|image"
        ];

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $user = User::find($id);
            $user->username = Input::get("username");
            if(Input::get("password")){
                $user->password = Hash::make(Input::get("password"));
            }
            $user->email = Input::get("email");
            if(Input::get("active")){
                $user->active = true;
            }
            $user->about = Input::get("about");
            $user->role = Input::get("role");
            $user->fullname = Input::get("fullname");

            $file1 = Input::file('background');

            if($file1) {
                $destinationPath = public_path() . '/backgrounds';
                $extension = $file1->getClientOriginalExtension();
                $filename = str_random(12) . "." . $extension;

                $file1->move($destinationPath, $filename);

                $user->background = $filename;
            }

            $file2 = Input::file('avatar');

            if($file2) {
                $destinationPath = public_path() . '/avatars';
                $extension = $file2->getClientOriginalExtension();
                $filename = str_random(12) . "." . $extension;

                $file2->move($destinationPath, $filename);

                $user->avatar = $filename;
            }

            $user->save();

            return Redirect::to(URL::action("Admin\UsersController@index"));
        }else{
            return Redirect::back()->withInput()->withErrors($validator);
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
        $user = User::withTrashed()->find($id);

        if(!Input::get("force")){
            $user->delete();
        }else{
            Event::where("user_id", "=", $user->id)->delete();
            Post::where("user_id", "=", $user->id)->delete();
            Comment::where("user_id", "=", $user->id)->delete();

            $user->forceDelete();
        }

        return Redirect::back();
	}

    public function trash(){
        $users = User::onlyTrashed()->paginate(20);

        return View::make("admin.users.trash")->with("users", $users);
    }

    public function restore($id){
        $user = User::withTrashed()->find($id);

        $user->restore();

        return Redirect::back();
    }

    public function ban($id){
        $user = User::find($id);
        $user->banned = true;
        $user->save();

        return Redirect::back();
    }

    public function unban($id){
        $user = User::find($id);
        $user->banned = false;
        $user->save();

        return Redirect::back();
    }

}
