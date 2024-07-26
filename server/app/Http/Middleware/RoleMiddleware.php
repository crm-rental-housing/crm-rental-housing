<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next, $roles): Response
  {
    try {
      $rolesArray = explode(' ', $roles);
      $user = auth()->user();
      foreach ($rolesArray as $role) {
        $role = trim($role);
        if ($user->role->value === $role) {
          return $next($request);
        }
      }
      return response()->json([
        'message' => 'Not found'
      ], 404);
    } catch (\Throwable $th) {
      echo $th;
      return response()->json([
        'message' => 'Произошла ошибка на сервере'
      ], 500);
    }    
  }
}
