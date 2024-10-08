<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectImageController;
use App\Http\Controllers\BlackListController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\AppartmentTypeController;
use App\Http\Controllers\AppartmentController;
use App\Http\Controllers\CompanyAdminController;
use App\Http\Controllers\DealController;

/**
 * Проверь все маршруты
 * Подумай над тем, чтобы у застройщиков была возможность работать только внутри своей компании
 * Если будет время, добавь рекламный кабинет
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

/**
 * Регистрация, авторизация, выход из системы, обновление токенов
 */
Route::prefix('auth')->group(function() {
  Route::post('register', [AuthController::class, 'register']);
  Route::post('login', [AuthController::class, 'login']);
  Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:api');
  Route::get('refresh', [AuthController::class, 'refresh']);
  Route::get('verify_email', [AuthController::class, 'verifyEmail']);
});

Route::get('companies', [CompanyController::class, 'index']);
Route::get('companies/{companyId}', [CompanyController::class, 'getOne']);

Route::get('projects', [ProjectController::class, 'index']);
Route::get('projects/{projectId}', [ProjectController::class, 'getOne']);

Route::get('entities', [EntityController::class, 'index']);
Route::get('entities/{entityId}', [EntityController::class, 'getOne']);
Route::get('project/{projectId}/entities', [EntityController::class, 'getProjectEntities']);

Route::get('appartments', [AppartmentController::class, 'index']);
Route::get('appartments/{appartmentId}', [AppartmentController::class, 'getOne']);
Route::get('entities/{entityId}/appartments', [AppartmentController::class, 'getEntityAppartments']);

/**
 * Доступ авторизованным пользователям
 */
Route::middleware(['auth:api', 'ban'])->group(function() {
  Route::get('users', [UserController::class, 'index']);
  Route::get('users/me', [UserController::class, 'me']);
  Route::put('users/{userId}', [UserController::class, 'update']);

  /**
   * Не доделано. Проблемы с загрузкой файлов изображений на сервер
   */
  Route::get('project/{projectId}/images', [ProjectImageController::class, 'index']);

  Route::get('payment_types', [PaymentTypeController::class, 'index']);

  Route::get('appartment_types', [AppartmentTypeController::class, 'index']);
});

/**
 * Доступ администраторам системы, менеджерам системы, SU
 */
Route::middleware(['auth:api', 'role:ADMIN MANAGER SUPERUSER'])->group(function() {
  
  Route::get('users/{userId}', [UserController::class, 'getOne']);
  Route::post('add_company_admin', [UserController::class, 'add'])->middleware('add_role:COMPANY_ADMIN');

  Route::post('companies', [CompanyController::class, 'add']);
  Route::put('companies/{companyId}', [CompanyController::class, 'update']);

  Route::get('black_list', [BlackListController::class, 'index']);
  Route::post('black_list', [BlackListController::class, 'ban']);
  Route::delete('black_list/{banId}', [BlackListController::class, 'unban']);
});

/**
 * Доступ администраторам системы, SU
 */
Route::middleware(['auth:api', 'role:ADMIN SUPERUSER'])->group(function() {
  Route::post('add_manager', [UserController::class, 'add'])->middleware('add_role:MANAGER');
  Route::get('deals/last', [AdminController::class, 'getLastDeals']);
  Route::get('admin/companies', [AdminController::class, 'getCompanies']);
  Route::get('managers', [AdminController::class, 'getManagers']);
});

/**
 * Доступ застройщикам (администраторам)
 * role:COMPANY_ADMIN - пока такое название роли, потом можно поменять
 */
Route::middleware(['auth:api', 'role:COMPANY_ADMIN'])->group(function() {
  Route::post('add_company_manager', [CompanyAdminController::class, 'createManager']);
  Route::get('get_company_managers', [CompanyAdminController::class, 'getManagers']);

  Route::delete('projects/{projectId}', [ProjectController::class, 'delete']);
});

/**
 * Доступ застройщикам (администраторам, менеджерам)
 * role:COMPANY_MANAGER - пока такое название роли, потом можно поменять
 */
Route::middleware(['auth:api', 'role:COMPANY_MANAGER COMPANY_ADMIN'])->group(function() {
  Route::post('projects', [ProjectController::class, 'add']);
  Route::put('projects/{projectId}', [ProjectController::class, 'update']);
  Route::post('deals', [DealController::class, 'add']);
  // /**
  //  * Не доделано
  //  * НУЖНО ДОБАВИТЬ ЗАГРУЗКУ ФАЙЛОВ ИЗОБРАЖЕНИЙ НА СЕРВЕР
  //  */
  // Route::prefix('projects/{projectId}')->group(function() {
  //   Route::post('images', [ProjectImageController::class, 'add']);
  //   Route::delete('images/{imageId}', [ProjectImageController::class, 'delete']);
  // });

  Route::post('projects/{projectId}/entities', [EntityController::class, 'add']);
  Route::put('projects/{projectId}/entities/{entityId}', [EntityController::class, 'update']);
  Route::delete('entities/{entityId}', [EntityController::class, 'delete']);

  /**
   * Надо написать парсер google sheets, для этого нужно создать сервисный аккаунт в google cloud platform
   * Напишу, если успею
   */
  Route::post('entities/{entityId}/appartments', [AppartmentController::class, 'add']);
  Route::post('entities/{entityId}/appartments/url', [AppartmentController::class, 'addAppartmentsWithUrl']);
  Route::put('entities/{entityId}/appartments/{appartmentId}', [AppartmentController::class, 'update']);
  Route::delete('appartments/{appartmentId}', [AppartmentController::class, 'delete']);
  
});

/**
 * Доступ только SU, ADMIN
 */
Route::middleware(['auth:api', 'role:SUPERUSER ADMIN'])->group(function () {
  Route::post('users', [UserController::class, 'add']);
  Route::delete('users/{userId}', [UserController::class, 'delete']);
  Route::put('users/{userId}/changeRole', [UserController::class, 'changeRole']);

  Route::delete('info/{infoId}', [RoleController::class, 'delete']);

  Route::get('roles', [RoleController::class, 'index']);
  Route::post('roles', [RoleController::class, 'add']);
  Route::put('roles', [RoleController::class, 'update']);
  Route::delete('roles', [RoleController::class, 'delete']);

  Route::delete('companies/{companyId}', [CompanyController::class, 'delete']);

  Route::get('payment_types/{paymentId}', [PaymentTypeController::class, 'getOne']);
  Route::post('payment_types', [PaymentTypeController::class, 'add']);
  Route::put('payment_types/{paymentId}', [PaymentTypeController::class, 'update']);
  Route::delete('payment_types/{paymentId}', [PaymentTypeController::class, 'delete']);

  Route::post('appartment_types', [AppartmentTypeController::class, 'add']);
  Route::put('appartment_types/{typeId}', [AppartmentTypeController::class, 'update']);
  Route::delete('appartment_types/{typeId}', [AppartmentTypeController::class, 'index']);
});