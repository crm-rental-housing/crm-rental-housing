<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Role;

class RoleController extends Controller
{
  public function index() {
    try {
      $roles = Role::orderBy('value', 'asc')->get();
        return response()->json([
          'roles' => $roles,
        ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Произошла ошибка при получении ролей'
      ], 500);
    }
  }

  public function add(Request $request) {
    try {
      $validatedData = $request->validate([
        'value' => 'required|string|min:4|unique:roles',
        'description' => 'required|string|min:10|max:100',
      ]);

      $role = Role::create([
        'value' => $validatedData['value'],
        'description' => $validatedData['description'],
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

  public function update(Request $request, $roleId) {
		try {
			$role = Role::where('id', $roleId)->first();
			if (!$role) {
				return response()->json([
					'message' => 'Роли с таким ID не существует'
				], 400);
			}
			$validatedData = $request->validate([
				'name' => ['required', 'string', 'min:4', Rule::unique('roles')->ignore($role->id)],
				'description' => ['required', 'string', 'min:10', 'max:100'],
			]);

			$role->update($validatedData);
			return response()->json([
				'message' => 'Данные успешно обновлены'
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось обновить данные'
			], 400);
		}
	}

	public function delete($roleId) {
		try {
			$role = Role::where('id', $roleId)->first();
			if (!$role) {
				return response()->json([
					'message' => 'Роли с таким ID не существует'
				], 400);
			}
			$role->delete();
			return response()->json([
        'message' => 'Роль успешно удалена'
      ]); 
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось удалить роль',
      ], 500);
    }
	}
}
