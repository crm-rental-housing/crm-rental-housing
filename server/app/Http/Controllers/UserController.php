<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\UserInfo;
use App\Models\Company;

class UserController extends Controller
{
  // переделать
  public function index() {
    $formattedUsers = [];
    foreach ($users = User::orderBy('email', 'asc')->cursor() as $user) {
      $formattedUsers[] = [
        'email' => $user->email,
        'role' => $user->role->value,
        'company' => $user->company ? $user->company->name : null,
        'info' => $user->info ? [
          'username' => $user->info->username,
          'first_name' => $user->info->first_name,
          'middle_name' => $user->info->middle_name,
          'last_name' => $user->inf0->last_name,
          'gender' => $user->info->gender,
          'birtdate' => $user->info->birthdate,
          'phone_number' => $user->info->phone_number,
        ] : null,
        'ban' => $user->ban ? [
          'is_banned' => $user->ban->is_banned,
          'banned_at' => $user->ban->banned_at,
        ] : null,
      ];
    }

    if (empty($formattedUsers)) {
      return response()->json([
        'message' => 'Пользователи не найдены'
      ], 404);
    }
    
    return response()->json([
      'users' => $formattedUsers
    ]);
  }

  public function getOne($userId) {
    $user = User::where('id', $userId)->first();
    if (!$user) {
      return response()->json([
        'message' => 'Not found'
      ], 404);
    }
    return response()->json([
      'user' => [
        'email' => $user->email,
        'role' => $user->role->value,
        'company' => $user->company ? $user->company->name : null,
        'info' => $user->info ? [
          'username' => $user->info->username,
          'first_name' => $user->info->first_name,
          'middle_name' => $user->info->middle_name,
          'last_name' => $user->inf0->last_name,
          'gender' => $user->info->gender,
          'birtdate' => $user->info->birthdate,
          'phone_number' => $user->info->phone_number,
        ] : null,
        'ban' => $user->ban ? [
          'is_banned' => $user->ban->is_banned,
          'banned_at' => $user->ban->banned_at,
        ] : null,
      ]
    ]);
  }

  public function add(Request $request) {
    $validatedData = Validator::make($request->all(), [
      'email' => 'required|string|email|unique:users',
      'password' => 'required|string|min:8',
      'role' => 'required|string',
      'company_id' => 'nullable|string',
    ]);

    if ($validatedData->fails()) {
      return response()->json([
        'message' => 'Некорректный ввод'
      ], 400);
    }

    $role = Role::where('value', $request['role'])->first();
    if (!$role) {
      return response()->json([
        'message' => 'Роли с таким названием не существует'
      ], 404);
    }

    if ($request['company_id'] !== null) {
      if (!Company::where('id', $request['company_id'])->first()) {
        return response()->json([
          'message' => 'Компании с таким ID не существует'
        ], 404);
      }
    }

    $user = User::create([
      'email' => $request['email'],
      'password' => Hash::make($request['password']),
      'role_id' => $role->id,
      'company_id' => $request['company_id'],
    ]);
    UserInfo::create(['user_id' => $user->id]);
    
    return response()->json([
      'message' => 'Пользователь успешно добавлен',
    ]);
  }

  public function update(Request $request, $userId) {
    $user = User::where('id', $userId)->first();
    if (!$user) {
      return response()->json([
        'message' => 'Пользователя с таким ID не существует'
      ], 404);
    }
    // Дополнить или переделать
		if (auth()->user()->id !== $user->id || auth()->user()->role->value !== 'ADMIN') {
			return response()->json([
				'message' => 'У вас нет прав на обновление данных пользователя'
			], 400);
		}
    $userInfo = UserInfo::where('user_id', $user->id)->first();

    $validatedUserData = Validator::make($request->only(['email', 'password']), [
      'email' => ['required', 'string', 'email', Rule::unique('users')->ignore($user->id)],
      'password' => ['required', 'string'],
    ]);
    $validatedInfoData = Validator::make(
      $request->only(
        ['username', 'first_name', 'middle_name', 'last_name', 'gender', 'birthdate', 'phone_number']
      ), [
      'username' => ['nullable', 'string', Rule::unique('user_infos')->ignore($userInfo->id)],
      'first_name' => ['nullable', 'string'],
      'middle_name' => ['nullable', 'string'],
      'last_name' => ['nullable', 'string'],
      'gender' => ['nullable', 'string'],
      'birthdate' => ['nullable', 'string'],
      'phone_number' => ['nullable', 'string', Rule::unique('user_infos')->ignore($userInfo->phone_number)],
      'user_id' => $userInfo->user_id,
    ]);

    if ($validatedData->fails() || $validatedInfoData->fails()) {
      return response()->json([
        'message' => 'Некорректный ввод'
      ], 400);
    }
    $newUserData = [
      'email' => $request['email'],
      'password' => Hash::make($request['password']),
    ];

    $newUserInfoData = [
      'username' => $request['username'],
      'first_name' => $request['first_name'],
      'middle_name' => $request['middle_name'],
      'last_name' => $request['last_name'],
      'gender' => $request['gender'],
      'birthdate' => $request['birthdate'],
      'phone_number' => $request['phone_number'],
      'user_id' => $userInfo->user_id,
    ];
    
    $user->update($newData);
    $userInfo->update($newUserInfoData);
    return response()->json([
      'message' => 'Данные пользователя успешно обновлены'
    ]);
  }

  public function delete($userId) {
    try {
      $user = User::where('id', $userId)->first();
      if (!$user) {
        return response()->json([
          'message' => "Пользователя с ID '$userId' не существует"
        ], 404);
      }
      $userInfo = UserInfo::where('user_id', $user->id);

      $userInfo->delete();
      $user->delete();
      
      return response()->json([
        'message' => 'Пользователь успешно удален'
      ]); 
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось удалить пользователя',
      ], 500);
    }
  }

  public function me() {
    $user = auth()->user();
    return response()->json([
      'user' => [
        'email' => $user->email,
        'company' => $user->company ? $user->company->name : null,
        'info' => $user->info ? [
          'username' => $user->info->username,
          'first_name' => $user->info->first_name,
          'middle_name' => $user->info->middle_name,
          'last_name' => $user->inf0->last_name,
          'gender' => $user->info->gender,
          'birtdate' => $user->info->birthdate,
          'phone_number' => $user->info->phone_number,
        ] : null,
        'ban' => $user->ban ? [
          'is_banned' => $user->ban->is_banned,
          'banned_at' => $user->ban->banned_at,
        ] : null,
      ]
    ]);
  }

  public function changeRole(Request $request, $userId) {
    try {
      $user = User::where('id', $userId)->first();
      $validatedData = $request->validate([
        'role' => 'required|string'
      ]);
      $role = Role::where('value', $validatedData['role'])->first();
      if (!$role) {
        return response()->json([
          'message' => 'Роли с таким названием не существует'
        ], 404);
      }
      $user->role_id = $role->id;
      $user->save();
      return response()->json([
        'message' => 'Роль пользователя успешно обновлена'
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось обновить роль пользователя'
      ]);
    }
  }
}
