<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class Authenticate
{
  public function handle(Request $request, Closure $next)
  {
		try {
			if (!auth()->user()) {
				return response()->json([
					'message' => 'Вы не авторизованы'
				], 401);
			}
			return $next($request);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Произошла ошибка'
			], 500);
		}
  }
}
