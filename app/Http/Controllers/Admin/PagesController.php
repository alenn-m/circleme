<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Http\Models\Page;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Response;
use URL;
use Validator;
use View;

class PagesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pages = Page::paginate(20);
        return View::make("admin.pages.index", compact("pages"));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make("admin.pages.create");
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [
            "short_title" => "required|min:1|max:15",
            "title" => "required",
            "body" => "required"
        ];

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $page = new Page;
            $page->short_title = Input::get("short_title");
            $page->title = Input::get("title");
            $page->body = Input::get("body");

            $page->save();

            return Redirect::to(URL::action("Admin\PagesController@index"));
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
		$page = Page::find($id);
        return View::make("admin.pages.edit", compact("page"));
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
            "short_title" => "required|min:1|max:15",
            "title" => "required",
            "body" => "required"
        ];

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()){
            $page = Page::find($id);
            $page->short_title = Input::get("short_title");
            $page->title = Input::get("title");
            $page->body = Input::get("body");

            $page->save();

            return Redirect::to(URL::action("Admin\PagesController@index"));
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
		$page = Page::withTrashed()->find($id);
        if(Input::get("force")){
            $page->forceDelete();
        }else{
            $page->delete();
        }

        return Redirect::back();
	}

    /**
     * Get trashed elements
     * @return \Illuminate\View\View
     */
    public function trash(){
        $pages = Page::onlyTrashed()->paginate(20);

        return View::make("admin.pages.trash", compact("pages"));
    }

    /**
     * Restore from trash
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id){
        $page = Page::withTrashed()->find($id);

        $page->restore();

        return Redirect::back();
    }

}
