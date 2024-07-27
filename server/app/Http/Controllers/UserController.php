<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\UserInfo;

class UserController extends Controller
{
  // переделать
  public function index() {
    try {
      $users = User::orderBy('email', 'asc')->get(); // или User::all()
      return response()->json([
        'users' => $users
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось получить пользователей',
      ], 400);
    }
  }

  public function getOne($userId) {
    try {
      $user = User::where('id', $userId)->first();
      if (!$user) {
        return response()->json([
          'message' => 'Not found'
        ], 404);
      }
      return response()->json([
        'user' => [
          'email' => $user->email,
          'info' => $user->info,
          'role' => $user->role->value,
        ]
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось получить данные пользователя',
      ], 400);
    }
  }

  public function add(Request $request) {
    try {
      $validatedData = $request->validate([
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|min:8',
        'role' => 'required|string',
        'company_id' => 'nullable|string',
      ]);

      $role = Role::where('value', $validatedData['role'])->first();
      if (!$role) {
        return response()->json([
          'message' => 'Роли с таким названием не существует'
        ], 404);
      }

      $user = User::create([
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'role_id' => $role->id,
        'company_id' => $validatedData['company_id'],
      ]);
      UserInfo::create(['user_id' => $user->id]);
    
      return response()->json([
        'message' => 'Пользователь успешно добавлен',
      ]);
    } catch (\Throwable $th) {
      echo $th;
      return response()->json([
        'message' => 'Не удалось добавить пользователя',
      ], 400);
    }
  }

  public function update(Request $request, $userId) {
    try {
      $user = User::where('id', $userId)->first();
      if (!$user) {
        return response()->json([
          'message' => 'Not found'
        ], 404);
      }
      // Дополнить или переделать
			if (auth()->user()->id !== $user->id || auth()->user()->role->value !== 'ADMIN') {
				return response()->json([
					'message' => 'У вас нет прав на обновление данных пользователя'
				], 400);
			}
      $userInfo = UserInfo::where('user_id', $user->id)->first();

      $validatedUserData = $request->validate([
        'email' => ['required', 'string', 'email', Rule::unique('users')->ignore($user->id)],
        'password' => ['required', 'string'],
      ]);
      $validatedInfoData = $request->validate([
        'username' => ['nullable', 'string', Rule::unique('user_infos')->ignore($userInfo->id)],
        'first_name' => ['nullable', 'string'],
        'middle_name' => ['nullable', 'string'],
        'last_name' => ['nullable', 'string'],
        'gender' => ['nullable', 'string'],
        'birthdate' => ['nullable', 'string'],
        'phone_number' => ['nullable', 'string'],
        'user_id' => $userInfo->user_id,
      ]);

      $newUserData = [
        'email' => $validatedUserData['email'],
        'password' => Hash::make($validatedUserData['password']),
      ];
      
      $user->update($newData);
      $userInfo->update($validatedInfoData);
      return response()->json([
        'message' => 'Данные пользователя успешно обновлены'
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось обновить данные пользователя'
      ], 400);
    }
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
    try {
      $user = auth()->user();
      return response()->json([
        'data' => [
          'user' => [
            'email' => $user->email,
            'info' => $user->info,
            'company_id' => $user->company_id,
          ],
        ]
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Произошла ошибка',
      ], 400);
    }
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
