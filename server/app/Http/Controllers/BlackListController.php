<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlackListController extends Controller
{
  public function index() {
    try {
      $bans = Role::orderBy('banned_at', 'asc')->get();
        return response()->json([
          'bans' => $bans,
        ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Произошла ошибка при получении списка банов'
      ], 500);
    }
  }

  public function ban(Request $request) {
    try {
      $validatedData = $request->validate([
        'reason' => 'required|string|min:4|unique:roles',
        'user_id' => 'required|string',
      ]);

      $ban = BlackList::create([
        'is_banned' => true,
        'reason' => $validatedData['reason'],
        'banned_at' => now(),
        'user_id' => $validatedData['user_id'],
      ]);

      return response()->json([
        'message' => 'Пользователь забанен'
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Произошла ошибка при добавлении бана'
      ], 400);
    }
  }

	public function unban($banId) {
		try {
			$ban = BlackList::where('id', $banId)->first();
			if (!$ban) {
				return response()->json([
					'message' => 'Бана с таким ID не существует'
				], 400);
			}
			$ban->delete();
			return response()->json([
        'message' => 'Пользователь успешно разбанен'
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось разбанить пользователя',
      ], 500);
    }
	}
}
