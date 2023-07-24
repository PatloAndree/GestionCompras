<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $role1, $role2 = null, $role3 = null, $role4 = null)
	{

		if ($request->user()->type == $role1 || $request->user()->type == $role2 || $request->user()->type == $role3 || $request->user()->type == $role4) {
			return $next($request);
		} else {
			abort(401, 'This action is unauthorized.');
		}
	}
}
