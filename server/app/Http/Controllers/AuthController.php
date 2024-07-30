<?php

namespace App\Http\Controllers;

use Validator;
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
use App\Models\UserInfo;
use App\Mail\EmailVerification;

/**
 * ДОБАВИТЬ ПОДТВЕРЖДЕНИЕ ПОЧТЫ (ВОЗМОЖНО, ДОБАВИТЬ ПОДТВЕРЖДЕНИЕ НОМЕРА ТЕЛЕФОНА)
 */

class AuthController extends Controller
{
  public function register(Request $request) {
    $validatedData = Validator::make($request->all(), [
      'email' => 'required|string|unique:users',
      'password' => 'required|string|min:8'
    ]);

    if ($validatedData->fails()) {
      return response()->json([
        'message' => 'Некорректный ввод, возможно данный email уже занят'
      ], 400);
    }

    $role = Role::where('value', 'USER')->first();

    $user = User::create([
      'email' => $request['email'],
      'password' => Hash::make($request['password']),
      'role_id' => $role->id, // ID роли пользователя
    ]);
    UserInfo::create(['user_id' => $user->id]);

    // Mail::to($user->email)->send(new EmailVerification($user));
    
    $accessToken = JWTAuth::fromUser($user);
    $refreshToken = $this->generateRefreshToken($user);
    
    return $this->respondWithTokens($accessToken, $refreshToken);
  }

  public function login(Request $request) {
    $validatedData = Validator::make($request->all(), [
      'email' => 'required|string|email',
      'password' => 'required|string'
    ]);
    if ($validatedData->fails()) {
      return response()->json([
        'message' => 'Некорректный ввод',
      ], 400);
    }

    $user = User::where('email', $request['email'])->first();
    if (!$user || !Hash::check($request['password'], $user->password)) {
      return response()->json([
        'message' => 'Неверное имя пользователя или пароль'
      ], 400);
    }
    if (count(RefreshToken::where('user_id', $user->id)->get()) >= 5) {
      return response()->json([
        'message' => 'Вы пытаетесь авторизоваться с более чем 5 устройств',
      ], 400);
    }
    $accessToken = JWTAuth::fromUser($user);
    $refreshToken = $this->generateRefreshToken($user);
    return $this->respondWithTokens($accessToken, $refreshToken);
  }

  public function logout(Request $request) {
    $refreshToken = $request->only('refresh_token');
    if (!$refreshToken) {
      return response()->json([
        'message' => 'Refresh token not provided'
      ], 404);
    }
    RefreshToken::where('value', $refreshToken)->delete();
    auth()->logout();
    return response()->json([
      'message' => 'Вы успешно вышли из системы'
    ]);
  }

  public function refresh(Request $request) {
    $requestRefreshToken = $request->only('refresh_token');
    if (!$requestRefreshToken) {
      return response()->json([
        'message' => 'Refresh token not provided'
      ], 404);
    }
    $refreshToken = RefreshToken::where('value', $requestRefreshToken)
      ->where('expires_in', '>', now())
      ->first();
    if (!$refreshToken) {
      $refreshToken->delete();
      return response()->json([
        'message' => 'Авторизуйтесь заново',
      ], 404); 
    }
    $user = User::where('id', $refreshToken->user_id)->first();
    $newRefreshToken = $this->generateRefreshToken($user);
    $newAccessToken = JWTAuth::fromUser($user);
    return $this->respondWithTokens($newAccessToken, $newRefreshToken);
  }

  protected function respondWithTokens($accessToken, $refreshToken) {
    return response()
      ->json([
        'access_token' => [
          'token' => $accessToken,
          'type' => 'Bearer',
          'expires_in' => auth()->factory()->getTTL() * 60,
        ],
        'refresh_token' => [
          'token' => $refreshToken[0],
          'expires_in' => $refreshToken[1],
        ]
      ]);
  }

  protected function generateRefreshToken($user) {
    $refreshToken = bin2hex(random_bytes(32));
    $expiresIn = now()->addDays(10);
    $expiresInSeconds = $expiresIn->timestamp;

    $token = [$refreshToken, $expiresInSeconds];
    $refreshTokenModel = RefreshToken::create([
      'value' => $refreshToken,
      'expires_in' => $expiresIn,
      'user_id' => $user->id,
    ]);

    // $refreshTokenCookie = Cookie::make(
    //   'refresh_token', // Название
    //   $refreshToken, // Значение
    //   $expiresInSeconds, // Время жизни в секундах
    //   '/', // Путь
    //   'localhost', // Домен
    //   false, // Secure (true для HTTPS)
    //   false, // httpOnly
    //   'Lax' // SameSite
    // );

    return $token;
  }
}