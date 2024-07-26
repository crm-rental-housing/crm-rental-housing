<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\UserInfo;

class UserInfoController extends Controller
{
  public function index() {
    try {
      $infos = UserInfo::orderBy('username', 'asc')->get();
        return response()->json([
          'infos' => $infos,
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
        'username' => 'required|string|min:4|unique:user_infos',
        'first_name' => 'required|string|max:50',
        'middle_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'gender' => 'required|string|max:1',
        'birthdate' => 'required|string|max:10',
        'phone_number' => 'required|string|min:11|max:12',
        'user_id' => 'required|string',
      ]);

      $info = UserInfo::create([
        'username' => $validatedData['username'],
        'first_name' => $validatedData['first_name'],
        'middle_name' => $validatedData['middle_name'],
        'last_name' => $validatedData['last_name'],
        'gender' => $validatedData['gender'],
        'birthdate' => $validatedData['birthdate'],
        'phone_number' => $validatedData['phone_number'],
        'user_id' => $validatedData['user_id'],
      ]);

      return response()->json([
        'message' => 'Информация о пользователе добавлена'
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Произошла ошибка при добавлении информации о пользователе'
      ], 400);
    }
  }

  public function update(Request $request, $userId) {
		try {
			$info = UserInfo::where('user_id', $userId)->first();
			if (!$info) {
				return response()->json([
					'message' => 'Информации о пользователе с таким ID не существует'
				], 400);
			}
			$validatedData = $request->validate([
				'username' => ['required', 'string', 'min:4', Rule::unique('user_infos')->ignore($info->id)],
				'first_name' => ['required', 'string', 'max:50'],
				'middle_name' => ['required', 'string', 'max:50'],
				'last_name' => ['required', 'string', 'max:50'],
				'gender' => ['required', 'string', 'max:1'],
				'birthdate' => ['required', 'string', 'max:10'],
				'phone_number' => ['required', 'string', 'min:11', 'max:12'],
				'user_id' => $info->user_id,
			]);

			$info->update($validatedData);
			return response()->json([
				'message' => 'Данные успешно обновлены'
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось обновить данные'
			], 400);
		}
	}

	public function delete($infoId) {
		try {
			$info = UserInfo::where('id', $infoId)->first();
			if (!$info) {
				return response()->json([
					'message' => 'Информация о пользователе с таким ID не существует'
				], 404);
			}
			$info->delete();
			return response()->json([
        'message' => 'Информация о пользователе успешно удалена'
      ]); 
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось удалить информацию о пользователе',
      ], 500);
    }
	}
}
