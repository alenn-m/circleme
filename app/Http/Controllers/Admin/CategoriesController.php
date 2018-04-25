<?php namespace App\Http\Controllers\Admin;

use App\Http\Models\Category;
use App\Http\Models\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Input;
use Redirect;
use URL;
use Validator;
use View;

class CategoriesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$categories = Category::paginate(20);
        return View::make("admin.categories.index")->with("categories", $categories);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make("admin.categories.create");
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [
            "name" => "required"
        ];

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $category = new Category;
            $category->name = Input::get("name");
            $category->save();

            return Redirect::to(URL::action("Admin\CategoriesController@index"));
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
		$category = Category::find($id);
        return View::make("admin.categories.edit")->with("category", $category);
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
            "name" => "required"
        ];

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $category = Category::find($id);
            $category->name = Input::get("name");
            $category->save();

            return Redirect::to(URL::action("Admin\CategoriesController@index"));
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
        $category = Category::find($id);
        $category->allEvents()->detach();

        $category->delete();

        return Redirect::to(URL::action("Admin\CategoriesController@index"));
	}

}
