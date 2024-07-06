<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

/**
 * Подумай над перенаправлением на страницу login
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

/**
 * Регистрация, авторизация, выход из системы, обновление access_tokena
 */
Route::prefix('auth')->group(function() {
  Route::post('register', [AuthController::class, 'register']);
  Route::post('login', [AuthController::class, 'login']);
  Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
  Route::get('refresh', [AuthController::class, 'refresh'])->middleware('auth');
});

/**
 * Доступ только авторизованным пользователям
 */
Route::middleware('auth:api')->group(function() {
  Route::get('user/me', [UserController::class, 'me']);
  Route::put('user/{userId}', [UserController::class, 'update']);
  Route::delete('user/{userId}', [UserController::class, 'delete']);
});

/**
 * Доступ только администраторам
 */
Route::middleware(['auth', 'role:ADMIN'])->group(function() {
  Route::get('user', [UserController::class, 'index']);
  Route::post('user', [UserController::class, 'add']);
  Route::get('user/{userId}', [UserController::class, 'getOne']);
  Route::put('user/{userId}/changeRole', [UserController::class, 'changeRole']);
  
  Route::post('role', [RoleController::class, 'add']);
  Route::get('role', [RoleController::class, 'get']);
});

/**
 * Доступ только менеджерам
 */
Route::middleware(['auth', 'role:MANAGER'])->group(function() {

});

/**
 * Доступ только застройщикам (администраторам)
 * role:COMPANY_ADMIN - пока такое название роли, потом можно поменять
 */
Route::middleware(['auth, role:COMPANY_ADMIN'])->group(function() {

});

/**
 * Доступ только застройщикам (менеджерам)
 * role:COMPANY_MANAGER - пока такое название роли, потом можно поменять
 */
Route::middleware(['auth, role:COMPANY_MANAGER'])->group(function() {

});