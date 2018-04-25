<?php namespace App\Http\Middleware;

use Closure;
use HttpException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

class CheckForMaintenanceMode {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */

    protected $request;
    protected $app;

    public function __construct(Application $app, Request $request){
        $this->app = $app;
        $this->request = $request;
    }

    public function handle($request, Closure $next){
        if ($this->app->isDownForMaintenance() &&
            !in_array($this->request->getClientIp(), ['10.1.1.2', '127.0.0.1']))
        {
            throw new HttpException(503);
        }

        return $next($request);
    }

}
