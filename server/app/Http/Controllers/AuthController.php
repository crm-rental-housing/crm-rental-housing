<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Role;
use App\Models\RefreshToken;
use App\Mail\EmailVerification;

/**
 * НУЖНО ДОБАВИТЬ ПРОВЕРКУ НА ОПРЕДЕЛЕННОЕ КОЛ-ВО ОДНОВРЕМЕННЫХ СЕССИЙ
 */
class AuthController extends Controller
{
  public function register(Request $request) {
    try {
      $validatedData = $request->validate([
        'email' => 'required|string|max:50|unique:users',
        'password' => 'required|string|min:8'
      ]);

      $user = User::create([
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'role_id' => 2, // ID роли пользователя
      ]);

      Mail::to($user->email)->send(new EmailVerification($user));
    
      $accessToken = JWTAuth::fromUser($user);
      $refreshTokenCookie = $this->generateRefreshToken($user);
    
      return $this->respondWithTokens($accessToken, $refreshTokenCookie);
    } catch (\Throwable $th) {
      echo $th;
      return response()->json([
        'message' => 'Не удалось зарегистрироваться',
      ], 400);
    }
  }

  public function login(Request $request) {
    try {
      $validatedData = $request->validate([
        'email' => 'required|string',
        'password' => 'required|string'
      ]);

      $user = User::where('email', $validatedData['email'])->first();
      if (!$user || !Hash::check($validatedData['password'], $user->password)) {
        return response()->json([
          'message' => 'Неверное имя пользователя или пароль'
        ], 400);
      }
      $accessToken = JWTAuth::fromUser($user);
      $refreshTokenCookie = $this->generateRefreshToken($user);

      return $this->respondWithTokens($accessToken, $refreshTokenCookie);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось войти',
      ], 400);
    }
  }

  public function logout(Request $request) {
    try {
      $refreshToken = $request->cookie('refresh_token');
      if (!$refreshToken) {
        return response()->json([
          'message' => 'Refresh token not provided'
        ], 400);
      }
      RefreshToken::where('value', $refreshToken)->delete();
      auth()->logout();
      return response()
        ->json([
        'message' => 'Вы успешно вышли из системы'
        ])
        ->withCookie(Cookie::forget('refresh_token'));
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось выйти',
      ], 500);
    }
  }

  // Добавь проверку на время жизни refresh token
  public function refresh(Request $request) {
    try {
      $requestRefreshToken = $request->cookie('refresh_token');
      if (!$requestRefreshToken) {
        return response()->json([
          'message' => 'Refresh token not provided'
        ]);
      }
      RefreshToken::where('value', $requestRefreshToken)->delete();
      $user = auth()->user();
      $refreshTokenCookie = $this->generateRefreshToken($user);
      $newAccessToken = JWTAuth::fromUser($user);
      return $this->respondWithTokens($newAccessToken, $refreshTokenCookie);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Произошла ошибка',
      ], 400);
    }
  }

  protected function respondWithTokens($accessToken, $refreshToken) {
    return response()
      ->json([
        'data' => [
          'access_token' => [
            'token' => $accessToken,
            'type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
          ],
        ],
      ])
      ->withCookie($refreshToken);
  }

  protected function generateRefreshToken($user) {
    $refreshToken = bin2hex(random_bytes(32));
    $expiresIn = now()->addDays(10);
    $expiresInSeconds = $expiresIn->timestamp;

    $refreshTokenModel = RefreshToken::create([
      'value' => $refreshToken,
      'expires_in' => $expiresIn,
      'user_id' => $user->id,
    ]);

    $refreshTokenCookie = Cookie::make(
      'refresh_token', // Название
      $refreshToken, // Значение
      $expiresInSeconds, // Время жизни в секундах
      '/', // Путь
      '', // Домен
      false, // Secure (true для HTTPS)
      true, // httpOnly
      'strict' // SameSite
    );

    return $refreshTokenCookie;
  }
}