<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class AddRoleMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next, $role_name): Response
  {
    try {
      $role = Role::where('value', $role_name)->first();
      if (!$role) {
        return response()->json([
          'message' => 'Нет такой роли'
        ], 400);
      }
      $request->merge(['role' => $role->value]);
      return $next($request);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Произошла ошибка на сервере'
      ], 500);
    }    
  }
}
