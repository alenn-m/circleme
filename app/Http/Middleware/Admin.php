<?php namespace App\Http\Middleware;

use Auth;
use Closure;
use Redirect;
use URL;

class Admin {

	/**
	 * Check if user is admin
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if(Auth::user() && Auth::user()->role == "admin"){
            return $next($request);
        }else{
            return Redirect::to(URL::action("HomeController@home"));
        }
	}

}
