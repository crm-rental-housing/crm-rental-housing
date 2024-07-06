<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;

class RoleController extends Controller
{
  public function add(Request $request) {
    try {
      $validatedData = $request->validate([
        'name' => 'required|string|min:4|unique:roles'
      ]);

      $role = Role::create([
        'name' => $validatedData['name'],
      ]);

      return response()->json([
        'message' => 'Роль добавлена'
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Произошла ошибка при добавлении роли'
      ], 400);
    }
  }

  public function get() {
    try {
      $roles = Role::all();
        return response()->json([
          'roles' => $roles,
        ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Произошла ошибка при получении ролей'
      ], 400);
    }
  }
}
