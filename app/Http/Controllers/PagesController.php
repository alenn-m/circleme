<?php namespace App\Http\Controllers;

use App\Http\Models\Page;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use View;

class PagesController extends Controller {

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$page = Page::findorFail($id);

        return View::make("pages.show", compact("page"));
	}

}
