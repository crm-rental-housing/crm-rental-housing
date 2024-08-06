<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class Authenticate
{
  public function handle(Request $request, Closure $next)
  {
		if (!auth()->user()) {
			return response()->json([
				'message' => 'Вы не авторизованы'
			], 401);
		}
		return $next($request);
  }
}
