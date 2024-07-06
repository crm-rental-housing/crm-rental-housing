<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
  public function index() {
    try {
      $users = User::orderBy('username', 'asc')->get(); // или User::all()
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
          'message' => "Пользователя с ID '$userId' не существует"
        ]);
      }
      return response()->json([
        'user' => [
          'username' => $user->username,
          'role' => $user->role->name,
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
        'username' => 'required|string|max:20|unique:users',
        'password' => 'required|string|min:8',
        'role' => 'required|string'
      ]);

      $role = Role::where('name', $validatedData['role'])->first();
      if (!$role) {
        return response()->json([
          'message' => 'Роли с таким названием не существует'
        ], 400);
      }

      $user = User::create([
        'username' => $validatedData['username'],
        'password' => Hash::make($validatedData['password']),
        'role_id' => $role->id,
      ]);
    
      return response()->json([
        'message' => 'Пользователь успешно добавлен',
      ]);
    } catch (\Throwable $th) {
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
          'message' => "Пользователя с ID '$userId' не существует"
        ]);
      }

      $validatedData = $request->validate([
        'username' => 'required|string|max:255|unique:users',
        'password' => 'required|string|min:8',
      ]);

      $newData = [
        'username' => $validatedData['username'],
        'password' => Hash::make($validatedData['password']),
      ];
      
      $user->update($newData);
      return response()->json([
        'message' => 'Данные пользователя успешно обновлены'
      ]);
    } catch (\Throwable $th) {
      echo $th;
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
        ]);
      }
      $user->delete();
      return response()->json([
        'message' => 'Пользователь успешно удален'
      ]); 
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось удалить пользователя',
      ], 400);
    }
  }

  public function me() {
    try {
      $user = auth()->user();
      return response()->json([
        'data' => [
          'user' => [
            'username' => $user['username'],
            'role' => $user->role->name,
          ]
        ],
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
      $role = Role::where('name', $validatedData['role'])->first();
      if (!$role) {
        return response()->json([
          'message' => 'Роли с таким названием не существует'
        ], 400);
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
