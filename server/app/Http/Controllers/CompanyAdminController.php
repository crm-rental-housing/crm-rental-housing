<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Role;

class CompanyAdminController extends Controller
{
  public function index() {

  }

  public function getManagers() {
    $managers = [];
    foreach(User::where('company_id', auth()->user()->company_id)->cursor() as $manager) {
      $managers[] = [
        'email' => $user->email,
        'role' => $user->role->value,
        'info' => $user->info ? [
          'username' => $user->info->username,
          'first_name' => $user->info->first_name,
          'middle_name' => $user->info->middle_name,
          'last_name' => $user->inf0->last_name,
          'gender' => $user->info->gender,
          'birtdate' => $user->info->birthdate,
          'phone_number' => $user->info->phone_number,
        ] : null,
      ];
    }

    if (empty($managers)) {
      return response()->json([
        'message' => 'В вашей компании нет менеджеров'
      ]);
    }

    return response()->json([
      'managers' => $managers,
    ]);
  }

  public function createManager(Request $request) {
    $validatedData = Validator::make($request->all(), [
      'email' => 'required|email|max:50|unique:users',
      'password' => 'required|string|min:8',
    ]);

    if ($validatedData->fails()) {
      return response()->json([
        'message' => 'Некорректный ввод'
      ], 400);
    }

    $role = Role::where('value', 'MANAGER')->first();
    $manager = User::create([
      'email' => $request['email'],
      'password' => Hash::make($request['password']),
      'role_id' => $role->id,
      'company_id' => auth()->user()->company_id,
    ]);

    UserInfo::create(['user_id' => $manager->id]);
    return response()->json([
      'message' => 'Менеджер успешно добален. Запомните введенные данные',
      'important' => [
        'email' => $manager->email,
        'password' => $request['password'],
      ],
    ]);
  }
}
